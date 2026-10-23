<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MockInsurerService;
use App\Services\PolicyIssuanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MockInsurerController extends Controller
{
    public function __construct(
        protected PolicyIssuanceService $issuanceService,
        protected MockInsurerService $mockInsurer
    ) {}

    /**
     * POST /api/mock-insurer/callback
     * Receive a simulated provider event.
     */
    public function callback(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'event_id' => ['required', 'string'],
            'event_type' => ['nullable', 'string'],
            'provider_reference' => ['nullable', 'string'],
            'client_request_id' => ['nullable', 'string'],
            'status' => ['nullable', 'string'],
            'policy_number' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid provider callback payload.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $result = $this->issuanceService->processProviderEvent($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ], 200);
    }

    /**
     * GET /api/mock-insurer/status/{identifier}
     * External status lookup for reconciliation.
     */
    public function lookupStatus(string $identifier): JsonResponse
    {
        $status = $this->mockInsurer->lookupStatus($identifier);

        if (! $status) {
            return response()->json([
                'status' => 'NOT_FOUND',
                'message' => "No record found at insurer for identifier '{$identifier}'.",
            ], 404);
        }

        return response()->json([
            'status' => 'FOUND',
            'data' => $status,
        ], 200);
    }

    /**
     * POST /api/mock-insurer/trigger-callback
     * Helper to trigger a callback for a specific policy (for UI and manual testing).
     */
    public function triggerCallback(Request $request): JsonResponse
    {
        $request->validate([
            'provider_reference' => ['required', 'string'],
            'client_request_id' => ['required', 'string'],
            'duplicate_count' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $providerRef = $request->input('provider_reference');
        $clientReqId = $request->input('client_request_id');
        $duplicateCount = (int) $request->input('duplicate_count', 1);

        $payload = $this->mockInsurer->generateCallbackPayload($providerRef, $clientReqId);

        $results = [];
        for ($i = 0; $i < $duplicateCount; $i++) {
            $results[] = $this->issuanceService->processProviderEvent($payload);
        }

        return response()->json([
            'status' => 'success',
            'sent_payload' => $payload,
            'results' => $results,
        ]);
    }
}
