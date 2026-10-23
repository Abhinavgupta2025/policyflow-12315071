<?php

namespace App\Services;

use App\Enums\PolicyStatus;
use App\Exceptions\InvalidStateTransitionException;
use App\Models\IssuanceAttempt;
use App\Models\PolicyRequest;
use App\Models\ProviderEvent;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PolicyIssuanceService
{
    public function __construct(
        protected PremiumCalculator $calculator,
        protected MockInsurerService $mockInsurer
    ) {}

    /**
     * Intake policy request idempotently.
     * Enforces (agent_id, client_request_id) uniqueness.
     *
     * @param array $data
     * @return array{policy: PolicyRequest, is_new: bool}
     */
    public function createOrRetrieveRequest(array $data): array
    {
        $agentId = trim($data['agent_id']);
        $clientRequestId = trim($data['client_request_id']);

        // Check for existing request first
        $existing = PolicyRequest::where('agent_id', $agentId)
            ->where('client_request_id', $clientRequestId)
            ->first();

        if ($existing) {
            return [
                'policy' => $existing,
                'is_new' => false,
            ];
        }

        // Calculate pricing snapshot
        $pricing = $this->calculator->calculate(
            planCode: $data['plan_code'],
            destination: $data['destination'],
            sumInsured: $data['sum_insured'],
            dob: $data['date_of_birth'],
            tripStart: $data['trip_start'],
            tripEnd: $data['trip_end']
        );

        try {
            return DB::transaction(function () use ($data, $agentId, $clientRequestId, $pricing) {
                // Double check inside transaction for race conditions
                $raceExisting = PolicyRequest::where('agent_id', $agentId)
                    ->where('client_request_id', $clientRequestId)
                    ->lockForUpdate()
                    ->first();

                if ($raceExisting) {
                    return [
                        'policy' => $raceExisting,
                        'is_new' => false,
                    ];
                }

                $policy = PolicyRequest::create([
                    'client_request_id' => $clientRequestId,
                    'agent_id' => $agentId,
                    'customer_name' => trim($data['customer_name']),
                    'date_of_birth' => $data['date_of_birth'],
                    'destination' => strtoupper(trim($data['destination'])),
                    'trip_start' => $data['trip_start'],
                    'trip_end' => $data['trip_end'],
                    'plan_code' => strtoupper(trim($data['plan_code'])),
                    'sum_insured' => (int) $data['sum_insured'],
                    'travel_days' => $pricing['travel_days'],
                    'calculated_premium' => $pricing['premium'],
                    'pricing_breakdown' => $pricing,
                    'status' => PolicyStatus::RECEIVED,
                ]);

                // Record initial state history
                $policy->stateHistories()->create([
                    'from_state' => null,
                    'to_state' => PolicyStatus::RECEIVED->value,
                    'reason' => 'Policy purchase request ingested.',
                    'metadata' => [
                        'agent_id' => $agentId,
                        'client_request_id' => $clientRequestId,
                    ],
                ]);

                // Transition to VALIDATED once pricing snapshot is set
                $policy->transitionTo(PolicyStatus::VALIDATED, 'Pricing calculated and validated successfully.', [
                    'premium' => $pricing['premium'],
                    'formula' => $pricing['formula'],
                ]);

                return [
                    'policy' => $policy->fresh(),
                    'is_new' => true,
                ];
            });
        } catch (QueryException $e) {
            // Handle database unique constraint collision gracefully (SQLSTATE 23000)
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'UNIQUE constraint failed') || str_contains($e->getMessage(), 'Duplicate entry')) {
                $recovered = PolicyRequest::where('agent_id', $agentId)
                    ->where('client_request_id', $clientRequestId)
                    ->firstOrFail();

                return [
                    'policy' => $recovered,
                    'is_new' => false,
                ];
            }

            throw $e;
        }
    }

    /**
     * Submit policy to mock insurer or safely resume issuance.
     *
     * @param PolicyRequest $policy
     * @param string $scenario
     * @return array
     */
    public function submitForIssuance(PolicyRequest $policy, string $scenario = MockInsurerService::SCENARIO_SUCCESS): array
    {
        // 1. If already issued, never re-issue or call provider again
        if ($policy->isIssued()) {
            return [
                'success' => true,
                'message' => 'Policy is already ISSUED. Safe idempotent response.',
                'policy' => $policy,
            ];
        }

        // 2. If needs reconciliation, prevent blind resubmission
        if ($policy->status === PolicyStatus::NEEDS_RECONCILIATION) {
            return [
                'success' => false,
                'status_code' => 409,
                'message' => 'Policy is in NEEDS_RECONCILIATION state. Run reconciliation before retrying.',
                'policy' => $policy,
            ];
        }

        // 3. Increment attempt and generate idempotency key
        $attemptNumber = $policy->attempt_count + 1;
        $idempotencyKey = "IDEM-{$policy->id}-ATTEMPT-{$attemptNumber}-" . Str::random(8);

        // Transition to SUBMITTED
        $policy->transitionTo(PolicyStatus::SUBMITTED, "Issuance attempt #{$attemptNumber} initiated.", [
            'attempt_number' => $attemptNumber,
            'scenario' => $scenario,
            'idempotency_key' => $idempotencyKey,
        ]);

        $policy->update(['attempt_count' => $attemptNumber]);

        $requestPayload = [
            'client_request_id' => $policy->client_request_id,
            'plan_code' => $policy->plan_code,
            'sum_insured' => $policy->sum_insured,
            'calculated_premium' => (float) $policy->calculated_premium,
            'customer_name' => $policy->customer_name,
            'destination' => $policy->destination,
            'travel_days' => $policy->travel_days,
            'idempotency_key' => $idempotencyKey,
        ];

        // 4. Call Mock Insurer
        $response = $this->mockInsurer->submit($policy, $scenario);

        // 5. Record attempt audit log
        $attempt = IssuanceAttempt::create([
            'policy_request_id' => $policy->id,
            'attempt_number' => $attemptNumber,
            'idempotency_key' => $idempotencyKey,
            'scenario' => $scenario,
            'request_payload' => $requestPayload,
            'response_payload' => $response,
            'http_status' => $response['status_code'] ?? 500,
            'status' => $response['status'] ?? 'FAILED',
            'error_message' => $response['error'] ?? null,
        ]);

        // 6. Handle outcome
        if (isset($response['status']) && $response['status'] === 'ISSUED') {
            $policy->update([
                'policy_number' => $response['policy_number'],
                'provider_reference' => $response['provider_reference'],
                'last_error' => null,
            ]);

            $policy->transitionTo(PolicyStatus::ISSUED, 'Policy issued successfully by insurer.', [
                'policy_number' => $response['policy_number'],
                'provider_reference' => $response['provider_reference'],
            ]);

            return [
                'success' => true,
                'status_code' => 200,
                'message' => 'Policy issued successfully.',
                'policy' => $policy->fresh(['attempts', 'stateHistories']),
            ];
        }

        if (isset($response['status']) && $response['status'] === 'TIMEOUT') {
            // Insurer may have created policy; client timed out. Do not blindly reissue!
            $policy->update([
                'last_error' => $response['error'] ?? 'Timeout during issuance.',
            ]);

            $policy->transitionTo(PolicyStatus::NEEDS_RECONCILIATION, 'Insurer timed out. Marked for reconciliation.', [
                'attempt_number' => $attemptNumber,
                'error' => $response['error'] ?? 'Timeout',
            ]);

            return [
                'success' => false,
                'status_code' => 504,
                'message' => 'Insurer timed out. State marked as NEEDS_RECONCILIATION.',
                'policy' => $policy->fresh(['attempts', 'stateHistories']),
            ];
        }

        if (isset($response['status']) && $response['status'] === 'PENDING_CONFIRMATION') {
            $policy->update([
                'provider_reference' => $response['provider_reference'] ?? null,
                'last_error' => null,
            ]);

            $policy->transitionTo(PolicyStatus::PENDING_CONFIRMATION, 'Awaiting asynchronous confirmation callback from insurer.', [
                'provider_reference' => $response['provider_reference'] ?? null,
            ]);

            return [
                'success' => true,
                'status_code' => 202,
                'message' => 'Issuance submitted; awaiting provider callback.',
                'policy' => $policy->fresh(['attempts', 'stateHistories']),
            ];
        }

        // Temporary or retriable failure
        $policy->update([
            'last_error' => $response['error'] ?? 'Issuance failed.',
        ]);

        $policy->transitionTo(PolicyStatus::FAILED, 'Insurer returned failure: ' . ($response['error'] ?? 'Unknown error'), [
            'attempt_number' => $attemptNumber,
            'error' => $response['error'] ?? null,
        ]);

        return [
            'success' => false,
            'status_code' => $response['status_code'] ?? 502,
            'message' => $response['error'] ?? 'Temporary issuance failure.',
            'policy' => $policy->fresh(['attempts', 'stateHistories']),
        ];
    }

    /**
     * Reconcile an ambiguous policy request by querying the insurer.
     */
    public function reconcile(PolicyRequest $policy): array
    {
        $statusInfo = $this->mockInsurer->lookupStatus($policy->client_request_id);

        if ($statusInfo && $statusInfo['status'] === 'ISSUED') {
            $policy->update([
                'policy_number' => $statusInfo['policy_number'],
                'provider_reference' => $statusInfo['provider_reference'],
                'last_error' => null,
            ]);

            $policy->transitionTo(PolicyStatus::ISSUED, 'Reconciliation confirmed policy was issued by insurer.', [
                'reconciled_from_status' => $policy->status->value,
                'policy_number' => $statusInfo['policy_number'],
                'provider_reference' => $statusInfo['provider_reference'],
            ]);

            return [
                'reconciled' => true,
                'status' => 'ISSUED',
                'message' => 'Policy verified as ISSUED with insurer.',
                'policy' => $policy->fresh(['attempts', 'stateHistories']),
            ];
        }

        // Provider has no record or record is failed
        if (! $statusInfo) {
            $policy->transitionTo(PolicyStatus::VALIDATED, 'Reconciliation found no active policy with insurer. Safe to retry.', [
                'reconciled_result' => 'NOT_FOUND_AT_PROVIDER',
            ]);

            return [
                'reconciled' => true,
                'status' => 'VALIDATED',
                'message' => 'No policy was created at insurer. Policy reset to VALIDATED for safe retry.',
                'policy' => $policy->fresh(['attempts', 'stateHistories']),
            ];
        }

        return [
            'reconciled' => false,
            'status' => $policy->status->value,
            'message' => 'Provider status: ' . $statusInfo['status'],
            'policy' => $policy->fresh(['attempts', 'stateHistories']),
        ];
    }

    /**
     * Handle incoming provider event/webhook callback idempotently.
     */
    public function processProviderEvent(array $payload): array
    {
        $eventId = $payload['event_id'] ?? null;
        if (! $eventId) {
            throw new Exception('Missing event_id in provider callback payload.');
        }

        // Idempotency check: duplicate callback
        $existingEvent = ProviderEvent::where('event_id', $eventId)->first();
        if ($existingEvent) {
            return [
                'status' => 'ALREADY_PROCESSED',
                'message' => "Duplicate event '{$eventId}' ignored safely. No state changes applied.",
                'event_id' => $eventId,
            ];
        }

        // Record incoming event
        $providerEvent = ProviderEvent::create([
            'event_id' => $eventId,
            'provider_reference' => $payload['provider_reference'] ?? 'UNKNOWN',
            'event_type' => $payload['event_type'] ?? 'POLICY_ISSUED',
            'payload' => $payload,
            'processed' => false,
        ]);

        // Find policy by provider_reference or client_request_id
        $policy = null;
        if (! empty($payload['provider_reference'])) {
            $policy = PolicyRequest::where('provider_reference', $payload['provider_reference'])->first();
        }
        if (! $policy && ! empty($payload['client_request_id'])) {
            $policy = PolicyRequest::where('client_request_id', $payload['client_request_id'])->first();
        }

        if (! $policy) {
            $providerEvent->update(['processed' => true, 'processed_at' => now()]);

            return [
                'status' => 'ORPHAN_EVENT',
                'message' => 'Event recorded but no matching policy request was found.',
                'event_id' => $eventId,
            ];
        }

        // If policy is already ISSUED, do not overwrite or perform invalid transition
        if ($policy->isIssued()) {
            $providerEvent->update(['processed' => true, 'processed_at' => now()]);

            return [
                'status' => 'ALREADY_ISSUED',
                'message' => 'Policy is already in confirmed ISSUED state. Event recorded without state overwrite.',
                'event_id' => $eventId,
                'policy_id' => $policy->id,
            ];
        }

        // Process successful issue event
        if (($payload['event_type'] ?? '') === 'POLICY_ISSUED' || ($payload['status'] ?? '') === 'ISSUED') {
            $policyNumber = $payload['policy_number'] ?? ('POL-' . date('Y') . '-' . strtoupper(Str::random(8)));
            $providerRef = $payload['provider_reference'] ?? $policy->provider_reference;

            $policy->update([
                'policy_number' => $policyNumber,
                'provider_reference' => $providerRef,
                'last_error' => null,
            ]);

            $policy->transitionTo(PolicyStatus::ISSUED, "Policy issued via provider event '{$eventId}'.", [
                'event_id' => $eventId,
                'event_type' => $payload['event_type'] ?? 'POLICY_ISSUED',
            ]);
        } elseif (($payload['event_type'] ?? '') === 'POLICY_REJECTED' || ($payload['status'] ?? '') === 'FAILED') {
            $policy->update([
                'last_error' => $payload['reason'] ?? 'Rejected by insurer callback.',
            ]);

            $policy->transitionTo(PolicyStatus::FAILED, "Provider callback reported failure: " . ($payload['reason'] ?? 'Unknown'), [
                'event_id' => $eventId,
            ]);
        }

        $providerEvent->update(['processed' => true, 'processed_at' => now()]);

        return [
            'status' => 'PROCESSED',
            'message' => 'Provider event processed successfully.',
            'event_id' => $eventId,
            'policy_id' => $policy->id,
            'policy_status' => $policy->status->value,
        ];
    }
}
