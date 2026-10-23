<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PolicyRequest;
use App\Services\PolicyIssuanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class PolicyRequestController extends Controller
{
    public function __construct(
        protected PolicyIssuanceService $issuanceService
    ) {}

    /**
     * POST /api/policy-requests
     * Create a new policy request or safely return existing request.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'client_request_id' => ['required', 'string', 'max:100'],
            'agent_id' => ['required', 'string', 'max:100'],
            'customer_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date_format:Y-m-d'],
            'destination' => ['required', 'string', 'in:DOMESTIC,INTERNATIONAL,domestic,international'],
            'trip_start' => ['required', 'date_format:Y-m-d'],
            'trip_end' => ['required', 'date_format:Y-m-d'],
            'plan_code' => ['required', 'string', 'in:BASIC,PLUS,PREMIUM,basic,plus,premium'],
            'sum_insured' => ['required', 'in:100000,300000,500000'],
        ], [
            'date_of_birth.date_format' => 'date_of_birth must be in Y-m-d format (e.g. 1998-04-10).',
            'trip_start.date_format' => 'trip_start must be in Y-m-d format (e.g. 2026-11-10).',
            'trip_end.date_format' => 'trip_end must be in Y-m-d format (e.g. 2026-11-14).',
            'destination.in' => 'destination must be either DOMESTIC or INTERNATIONAL.',
            'plan_code.in' => 'plan_code must be one of: BASIC, PLUS, PREMIUM.',
            'sum_insured.in' => 'sum_insured must be one of supported values: 100000, 300000, 500000.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed. Please review the provided fields.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Enforce trip_end >= trip_start date logic
        if ($validated['trip_end'] < $validated['trip_start']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Trip end date must be on or after trip start date.',
                'errors' => [
                    'trip_end' => ['trip_end must be greater than or equal to trip_start.'],
                ],
            ], 422);
        }

        // Validate date of birth is before trip start
        if ($validated['date_of_birth'] > $validated['trip_start']) {
            return response()->json([
                'status' => 'error',
                'message' => 'Date of birth cannot be after trip start date.',
                'errors' => [
                    'date_of_birth' => ['date_of_birth must be before or on trip_start.'],
                ],
            ], 422);
        }

        try {
            $result = $this->issuanceService->createOrRetrieveRequest($validated);
            $policy = $result['policy'];
            $isNew = $result['is_new'];

            return response()->json([
                'status' => 'success',
                'message' => $isNew
                    ? 'Policy purchase request created and validated.'
                    : 'Existing policy purchase request safely retrieved (idempotent submission).',
                'is_duplicate' => ! $isNew,
                'data' => [
                    'id' => $policy->id,
                    'client_request_id' => $policy->client_request_id,
                    'agent_id' => $policy->agent_id,
                    'customer_name' => $policy->customer_name,
                    'date_of_birth' => $policy->date_of_birth->format('Y-m-d'),
                    'destination' => $policy->destination,
                    'trip_start' => $policy->trip_start->format('Y-m-d'),
                    'trip_end' => $policy->trip_end->format('Y-m-d'),
                    'travel_days' => $policy->travel_days,
                    'plan_code' => $policy->plan_code,
                    'sum_insured' => $policy->sum_insured,
                    'calculated_premium' => (float) $policy->calculated_premium,
                    'pricing_breakdown' => $policy->pricing_breakdown,
                    'status' => $policy->status->value,
                    'policy_number' => $policy->policy_number,
                    'provider_reference' => $policy->provider_reference,
                    'attempt_count' => $policy->attempt_count,
                    'created_at' => $policy->created_at->toISOString(),
                    'updated_at' => $policy->updated_at->toISOString(),
                ],
            ], $isNew ? 201 : 200);
        } catch (InvalidArgumentException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * GET /api/policy-requests/{id}
     * Retrieve status, premium, references, issuance attempts, and audit trail.
     */
    public function show(string $id): JsonResponse
    {
        $policy = PolicyRequest::with(['attempts', 'stateHistories'])->find($id);

        if (! $policy) {
            // Also check by client_request_id
            $policy = PolicyRequest::with(['attempts', 'stateHistories'])
                ->where('client_request_id', $id)
                ->first();
        }

        if (! $policy) {
            return response()->json([
                'status' => 'error',
                'message' => "Policy request '{$id}' not found.",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $policy->id,
                'client_request_id' => $policy->client_request_id,
                'agent_id' => $policy->agent_id,
                'customer_name' => $policy->customer_name,
                'date_of_birth' => $policy->date_of_birth->format('Y-m-d'),
                'destination' => $policy->destination,
                'trip_start' => $policy->trip_start->format('Y-m-d'),
                'trip_end' => $policy->trip_end->format('Y-m-d'),
                'travel_days' => $policy->travel_days,
                'plan_code' => $policy->plan_code,
                'sum_insured' => $policy->sum_insured,
                'calculated_premium' => (float) $policy->calculated_premium,
                'pricing_breakdown' => $policy->pricing_breakdown,
                'status' => $policy->status->value,
                'policy_number' => $policy->policy_number,
                'provider_reference' => $policy->provider_reference,
                'attempt_count' => $policy->attempt_count,
                'last_error' => $policy->last_error,
                'issued_at' => $policy->issued_at?->toISOString(),
                'created_at' => $policy->created_at->toISOString(),
                'updated_at' => $policy->updated_at->toISOString(),
                'attempts' => $policy->attempts->map(fn ($a) => [
                    'id' => $a->id,
                    'attempt_number' => $a->attempt_number,
                    'idempotency_key' => $a->idempotency_key,
                    'scenario' => $a->scenario,
                    'http_status' => $a->http_status,
                    'status' => $a->status,
                    'error_message' => $a->error_message,
                    'created_at' => $a->created_at->toISOString(),
                ]),
                'audit_trail' => $policy->stateHistories->map(fn ($h) => [
                    'id' => $h->id,
                    'from_state' => $h->from_state,
                    'to_state' => $h->to_state,
                    'reason' => $h->reason,
                    'metadata' => $h->metadata,
                    'created_at' => $h->created_at->toISOString(),
                ]),
            ],
        ], 200);
    }

    /**
     * GET /api/policy-requests
     * List requests with status filter and pagination.
     */
    public function index(Request $request): JsonResponse
    {
        $query = PolicyRequest::query()->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', strtoupper($request->query('status')));
        }

        if ($request->filled('agent_id')) {
            $query->where('agent_id', $request->query('agent_id'));
        }

        if ($request->filled('search')) {
            $search = '%' . $request->query('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('client_request_id', 'like', $search)
                    ->orWhere('customer_name', 'like', $search)
                    ->orWhere('policy_number', 'like', $search)
                    ->orWhere('agent_id', 'like', $search);
            });
        }

        $perPage = (int) $request->query('per_page', 15);
        $paginated = $query->paginate(max(1, min(100, $perPage)));

        return response()->json([
            'status' => 'success',
            'data' => $paginated->items(),
            'pagination' => [
                'current_page' => $paginated->currentPage(),
                'last_page' => $paginated->lastPage(),
                'per_page' => $paginated->perPage(),
                'total' => $paginated->total(),
            ],
        ]);
    }

    /**
     * POST /api/policy-requests/{id}/submit
     * Start or safely resume issuance.
     */
    public function submit(Request $request, string $id): JsonResponse
    {
        $policy = PolicyRequest::find($id);

        if (! $policy) {
            $policy = PolicyRequest::where('client_request_id', $id)->first();
        }

        if (! $policy) {
            return response()->json([
                'status' => 'error',
                'message' => "Policy request '{$id}' not found.",
            ], 404);
        }

        // Optional scenario override for deterministic mock testing:
        // Reads from query, payload, or X-Mock-Scenario header
        $scenario = $request->input('scenario')
            ?: $request->header('X-Mock-Scenario')
            ?: 'SUCCESS';

        $result = $this->issuanceService->submitForIssuance($policy, $scenario);

        $httpStatus = $result['status_code'] ?? ($result['success'] ? 200 : 400);

        return response()->json([
            'status' => $result['success'] ? 'success' : 'error',
            'message' => $result['message'],
            'data' => [
                'id' => $policy->id,
                'client_request_id' => $policy->client_request_id,
                'status' => $result['policy']->status->value,
                'policy_number' => $result['policy']->policy_number,
                'provider_reference' => $result['policy']->provider_reference,
                'attempt_count' => $result['policy']->attempt_count,
                'last_error' => $result['policy']->last_error,
            ],
        ], $httpStatus);
    }

    /**
     * POST /api/policy-requests/{id}/reconcile
     * Reconcile an ambiguous state with mock provider.
     */
    public function reconcile(Request $request, string $id): JsonResponse
    {
        $policy = PolicyRequest::find($id);

        if (! $policy) {
            $policy = PolicyRequest::where('client_request_id', $id)->first();
        }

        if (! $policy) {
            return response()->json([
                'status' => 'error',
                'message' => "Policy request '{$id}' not found.",
            ], 404);
        }

        $result = $this->issuanceService->reconcile($policy);

        return response()->json([
            'status' => 'success',
            'message' => $result['message'],
            'data' => [
                'id' => $policy->id,
                'client_request_id' => $policy->client_request_id,
                'status' => $result['policy']->status->value,
                'policy_number' => $result['policy']->policy_number,
                'provider_reference' => $result['policy']->provider_reference,
            ],
        ]);
    }
}
