<?php

namespace App\Services;

use App\Models\MockProviderPolicy;
use App\Models\PolicyRequest;
use Exception;
use Illuminate\Support\Str;

class MockInsurerService
{
    public const SCENARIO_SUCCESS = 'SUCCESS';
    public const SCENARIO_TEMPORARY_FAILURE = 'TEMPORARY_FAILURE';
    public const SCENARIO_TIMEOUT_AFTER_ISSUE = 'TIMEOUT_AFTER_ISSUE';
    public const SCENARIO_DELAYED_CALLBACK = 'DELAYED_CALLBACK';
    public const SCENARIO_DUPLICATE_CALLBACK = 'DUPLICATE_CALLBACK';

    /**
     * Submit policy issuance to the simulated insurer.
     *
     * @param PolicyRequest $policy
     * @param string $scenario
     * @return array
     * @throws Exception
     */
    public function submit(PolicyRequest $policy, string $scenario = self::SCENARIO_SUCCESS): array
    {
        $clientRequestId = $policy->client_request_id;

        // Check if insurer already has a record for this client_request_id (idempotent lookup)
        $existing = MockProviderPolicy::where('client_request_id', $clientRequestId)->first();

        if ($existing) {
            return [
                'status_code' => 200,
                'status' => $existing->status,
                'policy_number' => $existing->policy_number,
                'provider_reference' => $existing->provider_reference,
                'message' => 'Policy already exists in insurer records.',
            ];
        }

        switch (strtoupper($scenario)) {
            case self::SCENARIO_TEMPORARY_FAILURE:
                return [
                    'status_code' => 503,
                    'status' => 'FAILED_RETRIABLE',
                    'error' => 'Insurer gateway temporary service interruption. Please retry.',
                ];

            case self::SCENARIO_TIMEOUT_AFTER_ISSUE:
                // Policy IS created on insurer side, but HTTP call times out before response reaches TrippersShield
                $providerRef = 'REF-' . strtoupper(Str::random(10));
                $policyNumber = 'POL-' . date('Y') . '-' . strtoupper(Str::random(8));

                MockProviderPolicy::create([
                    'client_request_id' => $clientRequestId,
                    'provider_reference' => $providerRef,
                    'policy_number' => $policyNumber,
                    'status' => 'ISSUED',
                    'plan_code' => $policy->plan_code,
                    'sum_insured' => $policy->sum_insured,
                    'premium' => $policy->calculated_premium,
                ]);

                return [
                    'status_code' => 504,
                    'status' => 'TIMEOUT',
                    'error' => 'Connection timed out waiting for insurer gateway response (simulated).',
                ];

            case self::SCENARIO_DELAYED_CALLBACK:
                $providerRef = 'REF-' . strtoupper(Str::random(10));

                MockProviderPolicy::create([
                    'client_request_id' => $clientRequestId,
                    'provider_reference' => $providerRef,
                    'policy_number' => 'PENDING-' . strtoupper(Str::random(6)),
                    'status' => 'PENDING',
                    'plan_code' => $policy->plan_code,
                    'sum_insured' => $policy->sum_insured,
                    'premium' => $policy->calculated_premium,
                ]);

                return [
                    'status_code' => 202,
                    'status' => 'PENDING_CONFIRMATION',
                    'provider_reference' => $providerRef,
                    'message' => 'Request received and queued for async underwriting. Callback event will follow.',
                ];

            case self::SCENARIO_DUPLICATE_CALLBACK:
            case self::SCENARIO_SUCCESS:
            default:
                $providerRef = 'REF-' . strtoupper(Str::random(10));
                $policyNumber = 'POL-' . date('Y') . '-' . strtoupper(Str::random(8));

                MockProviderPolicy::create([
                    'client_request_id' => $clientRequestId,
                    'provider_reference' => $providerRef,
                    'policy_number' => $policyNumber,
                    'status' => 'ISSUED',
                    'plan_code' => $policy->plan_code,
                    'sum_insured' => $policy->sum_insured,
                    'premium' => $policy->calculated_premium,
                ]);

                return [
                    'status_code' => 200,
                    'status' => 'ISSUED',
                    'policy_number' => $policyNumber,
                    'provider_reference' => $providerRef,
                    'message' => 'Policy issued successfully.',
                ];
        }
    }

    /**
     * Look up provider status for a given client_request_id or provider_reference (Reconciliation mechanism).
     */
    public function lookupStatus(string $identifier): ?array
    {
        $policy = MockProviderPolicy::where('client_request_id', $identifier)
            ->orWhere('provider_reference', $identifier)
            ->first();

        if (! $policy) {
            return null;
        }

        return [
            'client_request_id' => $policy->client_request_id,
            'provider_reference' => $policy->provider_reference,
            'policy_number' => $policy->policy_number,
            'status' => $policy->status,
            'plan_code' => $policy->plan_code,
            'premium' => (float) $policy->premium,
            'created_at' => $policy->created_at->toISOString(),
        ];
    }

    /**
     * Build a simulated callback event payload for delayed or duplicate callback testing.
     */
    public function generateCallbackPayload(
        string $providerReference,
        string $clientRequestId,
        string $eventType = 'POLICY_ISSUED',
        ?string $eventId = null
    ): array {
        $mock = MockProviderPolicy::where('provider_reference', $providerReference)
            ->orWhere('client_request_id', $clientRequestId)
            ->first();

        $policyNumber = $mock && ! str_starts_with($mock->policy_number, 'PENDING-')
            ? $mock->policy_number
            : 'POL-' . date('Y') . '-' . strtoupper(Str::random(8));

        if ($mock && str_starts_with($mock->policy_number, 'PENDING-')) {
            $mock->update([
                'policy_number' => $policyNumber,
                'status' => 'ISSUED',
            ]);
        }

        return [
            'event_id' => $eventId ?: 'EVT-' . strtoupper(Str::random(12)),
            'event_type' => $eventType,
            'provider_reference' => $providerReference,
            'client_request_id' => $clientRequestId,
            'policy_number' => $policyNumber,
            'status' => 'ISSUED',
            'timestamp' => now()->toISOString(),
        ];
    }
}
