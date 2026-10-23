<?php

namespace Tests\Feature;

use App\Enums\PolicyStatus;
use App\Models\PolicyRequest;
use App\Models\ProviderEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PolicyEngineTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: Valid request produces expected premium and status.
     * Verifies the exact example from the assignment specification:
     * client_request_id: AGT-2026-0001, agent_id: AGENT-17, DOB: 1998-04-10,
     * destination: INTERNATIONAL, trip: 2026-11-10 to 2026-11-14 (5 days),
     * plan: PLUS (₹20), sum_insured: 300000 (1.25x).
     * Expected premium = 20 * 5 * 1.00 * 1.80 * 1.25 = ₹225.00.
     */
    public function test_valid_request_produces_expected_premium_and_status(): void
    {
        $payload = [
            'client_request_id' => 'AGT-2026-0001',
            'agent_id' => 'AGENT-17',
            'customer_name' => 'Sample Customer',
            'date_of_birth' => '1998-04-10',
            'destination' => 'INTERNATIONAL',
            'trip_start' => '2026-11-10',
            'trip_end' => '2026-11-14',
            'plan_code' => 'PLUS',
            'sum_insured' => 300000,
        ];

        $response = $this->postJson('/api/policy-requests', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'is_duplicate' => false,
                'data' => [
                    'client_request_id' => 'AGT-2026-0001',
                    'agent_id' => 'AGENT-17',
                    'customer_name' => 'Sample Customer',
                    'destination' => 'INTERNATIONAL',
                    'travel_days' => 5,
                    'plan_code' => 'PLUS',
                    'sum_insured' => 300000,
                    'calculated_premium' => 225.00,
                    'status' => 'VALIDATED',
                ],
            ]);

        $this->assertDatabaseHas('policy_requests', [
            'client_request_id' => 'AGT-2026-0001',
            'agent_id' => 'AGENT-17',
            'status' => 'VALIDATED',
            'calculated_premium' => '225.00',
        ]);
    }

    /**
     * Test 2: Invalid travel dates and unsupported plan are rejected.
     */
    public function test_invalid_travel_dates_and_unsupported_plan_are_rejected(): void
    {
        // 1. Invalid date logic: trip_end < trip_start
        $invalidDatesPayload = [
            'client_request_id' => 'REQ-INVALID-DATE',
            'agent_id' => 'AGENT-1',
            'customer_name' => 'John Doe',
            'date_of_birth' => '1990-01-01',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-12-10',
            'trip_end' => '2026-12-05', // Earlier than start date!
            'plan_code' => 'BASIC',
            'sum_insured' => 100000,
        ];

        $res1 = $this->postJson('/api/policy-requests', $invalidDatesPayload);
        $res1->assertStatus(422)
            ->assertJsonValidationErrors(['trip_end']);

        // 2. Unsupported plan code
        $invalidPlanPayload = [
            'client_request_id' => 'REQ-INVALID-PLAN',
            'agent_id' => 'AGENT-1',
            'customer_name' => 'John Doe',
            'date_of_birth' => '1990-01-01',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-12-01',
            'trip_end' => '2026-12-05',
            'plan_code' => 'ULTRA_PLATINUM_INVALID',
            'sum_insured' => 100000,
        ];

        $res2 = $this->postJson('/api/policy-requests', $invalidPlanPayload);
        $res2->assertStatus(422)
            ->assertJsonValidationErrors(['plan_code']);

        // 3. Unsupported coverage amount
        $invalidCoveragePayload = [
            'client_request_id' => 'REQ-INVALID-COV',
            'agent_id' => 'AGENT-1',
            'customer_name' => 'John Doe',
            'date_of_birth' => '1990-01-01',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-12-01',
            'trip_end' => '2026-12-05',
            'plan_code' => 'BASIC',
            'sum_insured' => 9999999, // Unsupported sum insured
        ];

        $res3 = $this->postJson('/api/policy-requests', $invalidCoveragePayload);
        $res3->assertStatus(422)
            ->assertJsonValidationErrors(['sum_insured']);
    }

    /**
     * Test 3: Reliability Case 1 - Duplicate intake: repeated agent_id + client_request_id
     * returns HTTP 200 with existing request and does NOT create another logical request.
     */
    public function test_repeated_agent_and_client_request_id_does_not_create_duplicate_request(): void
    {
        $payload = [
            'client_request_id' => 'AGT-DUP-001',
            'agent_id' => 'AGENT-42',
            'customer_name' => 'Alice Smith',
            'date_of_birth' => '1985-05-15',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-10-01',
            'trip_end' => '2026-10-10', // 10 days, age 41 (1.00), DOMESTIC (1.00), BASIC (12), 100k (1.00) = 120.00
            'plan_code' => 'BASIC',
            'sum_insured' => 100000,
        ];

        // First intake: 201 Created
        $first = $this->postJson('/api/policy-requests', $payload);
        $first->assertStatus(201);
        $createdId = $first->json('data.id');

        // Repeated intake with identical agent_id + client_request_id: 200 OK
        $second = $this->postJson('/api/policy-requests', $payload);
        $second->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'is_duplicate' => true,
                'data' => [
                    'id' => $createdId,
                    'client_request_id' => 'AGT-DUP-001',
                    'agent_id' => 'AGENT-42',
                ],
            ]);

        // Assert database has exactly 1 row
        $this->assertEquals(1, PolicyRequest::where('client_request_id', 'AGT-DUP-001')->count());
    }

    /**
     * Test 4: Successful provider response produces exactly one policy number.
     */
    public function test_successful_provider_response_produces_exactly_one_policy_number(): void
    {
        $payload = [
            'client_request_id' => 'AGT-SUCCESS-001',
            'agent_id' => 'AGENT-07',
            'customer_name' => 'James Bond',
            'date_of_birth' => '1970-01-01',
            'destination' => 'INTERNATIONAL',
            'trip_start' => '2026-11-01',
            'trip_end' => '2026-11-05',
            'plan_code' => 'PREMIUM',
            'sum_insured' => 500000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $intake->assertStatus(201);
        $policyId = $intake->json('data.id');

        // Submit issuance with SUCCESS scenario
        $submit = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'SUCCESS',
        ]);

        $submit->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'id' => $policyId,
                    'status' => 'ISSUED',
                ],
            ]);

        $policyNumber = $submit->json('data.policy_number');
        $this->assertNotEmpty($policyNumber);

        // Verify policy status in database
        $policy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::ISSUED, $policy->status);
        $this->assertEquals($policyNumber, $policy->policy_number);

        // Submitting again to an already issued policy is safely idempotent
        $resubmit = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'SUCCESS',
        ]);
        $resubmit->assertStatus(200);
        $this->assertEquals($policyNumber, $policy->fresh()->policy_number);
    }

    /**
     * Test 5: Reliability Case 2 - Timeout after success:
     * Insurer creates policy internally, but client call times out.
     * System marks request as NEEDS_RECONCILIATION; reconciliation verifies and transitions to ISSUED without reissue.
     */
    public function test_timeout_after_success_and_reconciliation_recovery(): void
    {
        $payload = [
            'client_request_id' => 'AGT-TIMEOUT-001',
            'agent_id' => 'AGENT-88',
            'customer_name' => 'Sarah Connor',
            'date_of_birth' => '1984-02-28',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-11-20',
            'trip_end' => '2026-11-25',
            'plan_code' => 'PLUS',
            'sum_insured' => 300000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $policyId = $intake->json('data.id');

        // Submit with TIMEOUT_AFTER_ISSUE scenario
        $submit = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'TIMEOUT_AFTER_ISSUE',
        ]);

        $submit->assertStatus(504)
            ->assertJson([
                'status' => 'error',
                'data' => [
                    'status' => 'NEEDS_RECONCILIATION',
                ],
            ]);

        $policy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::NEEDS_RECONCILIATION, $policy->status);

        // Blind reissue while in NEEDS_RECONCILIATION is blocked
        $blockedSubmit = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'SUCCESS',
        ]);
        $blockedSubmit->assertStatus(409);

        // Perform reconciliation endpoint call
        $reconcileRes = $this->postJson("/api/policy-requests/{$policyId}/reconcile");
        $reconcileRes->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'status' => 'ISSUED',
                ],
            ]);

        $reconciledPolicy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::ISSUED, $reconciledPolicy->status);
        $this->assertNotNull($reconciledPolicy->policy_number);
        $this->assertNotNull($reconciledPolicy->provider_reference);
    }

    /**
     * Test 6: Reliability Case 3 - Duplicate callback:
     * The same provider event is delivered multiple times; processing must be idempotent.
     */
    public function test_duplicate_callback_is_safely_idempotent(): void
    {
        // Setup a pending confirmation policy
        $payload = [
            'client_request_id' => 'AGT-ASYNC-001',
            'agent_id' => 'AGENT-10',
            'customer_name' => 'Bruce Wayne',
            'date_of_birth' => '1980-05-27',
            'destination' => 'INTERNATIONAL',
            'trip_start' => '2026-12-01',
            'trip_end' => '2026-12-10',
            'plan_code' => 'PREMIUM',
            'sum_insured' => 500000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $policyId = $intake->json('data.id');

        // Submit with DELAYED_CALLBACK scenario
        $submit = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'DELAYED_CALLBACK',
        ]);
        $submit->assertStatus(202);

        $policy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::PENDING_CONFIRMATION, $policy->status);

        $callbackPayload = [
            'event_id' => 'EVT-WEBHOOK-99999',
            'event_type' => 'POLICY_ISSUED',
            'provider_reference' => $policy->provider_reference,
            'client_request_id' => $policy->client_request_id,
            'policy_number' => 'POL-FINAL-2026-12345',
            'status' => 'ISSUED',
        ];

        // 1st delivery of webhook callback: processes and transitions to ISSUED
        $cb1 = $this->postJson('/api/mock-insurer/callback', $callbackPayload);
        $cb1->assertStatus(200)
            ->assertJsonPath('data.status', 'PROCESSED');

        $this->assertEquals(PolicyStatus::ISSUED, PolicyRequest::find($policyId)->status);
        $this->assertEquals('POL-FINAL-2026-12345', PolicyRequest::find($policyId)->policy_number);

        // 2nd delivery of the exact same callback: returns ALREADY_PROCESSED safely
        $cb2 = $this->postJson('/api/mock-insurer/callback', $callbackPayload);
        $cb2->assertStatus(200)
            ->assertJsonPath('data.status', 'ALREADY_PROCESSED');

        // 3rd delivery of the exact same callback: returns ALREADY_PROCESSED safely
        $cb3 = $this->postJson('/api/mock-insurer/callback', $callbackPayload);
        $cb3->assertStatus(200)
            ->assertJsonPath('data.status', 'ALREADY_PROCESSED');

        // Ensure database has only 1 provider event record
        $this->assertEquals(1, ProviderEvent::where('event_id', 'EVT-WEBHOOK-99999')->count());
        $this->assertEquals(PolicyStatus::ISSUED, PolicyRequest::find($policyId)->status);
    }

    /**
     * Test 7: Reliability Case 4 - Retry after temporary failure:
     * Retries must not produce duplicate policies or lose the original accepted premium.
     */
    public function test_retry_after_temporary_failure_preserves_premium_and_succeeds(): void
    {
        $payload = [
            'client_request_id' => 'AGT-RETRY-001',
            'agent_id' => 'AGENT-55',
            'customer_name' => 'Clark Kent',
            'date_of_birth' => '1995-10-10',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-12-15',
            'trip_end' => '2026-12-20', // 6 days, BASIC (12), 100k (1.00) = 72.00
            'plan_code' => 'BASIC',
            'sum_insured' => 100000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $policyId = $intake->json('data.id');
        $originalPremium = $intake->json('data.calculated_premium');

        // Attempt 1: TEMPORARY_FAILURE
        $attempt1 = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'TEMPORARY_FAILURE',
        ]);
        $attempt1->assertStatus(503);

        $policy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::FAILED, $policy->status);
        $this->assertEquals(1, $policy->attempt_count);
        $this->assertEquals($originalPremium, (float) $policy->calculated_premium);

        // Attempt 2: Safe retry with SUCCESS scenario
        $attempt2 = $this->postJson("/api/policy-requests/{$policyId}/submit", [
            'scenario' => 'SUCCESS',
        ]);
        $attempt2->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'status' => 'ISSUED',
                ],
            ]);

        $issuedPolicy = PolicyRequest::with('attempts')->find($policyId);
        $this->assertEquals(PolicyStatus::ISSUED, $issuedPolicy->status);
        $this->assertEquals(2, $issuedPolicy->attempt_count);
        $this->assertEquals($originalPremium, (float) $issuedPolicy->calculated_premium);
        $this->assertCount(2, $issuedPolicy->attempts);
    }

    /**
     * Test 8: State regression prevention:
     * Once ISSUED, a request cannot be transitioned to SUBMITTED or FAILED.
     */
    public function test_cannot_overwrite_confirmed_issued_state(): void
    {
        $payload = [
            'client_request_id' => 'AGT-LOCK-001',
            'agent_id' => 'AGENT-99',
            'customer_name' => 'Diana Prince',
            'date_of_birth' => '1990-03-25',
            'destination' => 'INTERNATIONAL',
            'trip_start' => '2026-11-01',
            'trip_end' => '2026-11-03',
            'plan_code' => 'PLUS',
            'sum_insured' => 300000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $policyId = $intake->json('data.id');

        $this->postJson("/api/policy-requests/{$policyId}/submit", ['scenario' => 'SUCCESS'])->assertStatus(200);

        $policy = PolicyRequest::find($policyId);
        $this->assertEquals(PolicyStatus::ISSUED, $policy->status);

        // Attempting to send a late rejection callback must not overwrite ISSUED state
        $lateFailureCallback = [
            'event_id' => 'EVT-LATE-FAIL-001',
            'event_type' => 'POLICY_REJECTED',
            'provider_reference' => $policy->provider_reference,
            'client_request_id' => $policy->client_request_id,
            'reason' => 'Late underwriting rejection',
        ];

        $cb = $this->postJson('/api/mock-insurer/callback', $lateFailureCallback);
        $cb->assertStatus(200)
            ->assertJsonPath('data.status', 'ALREADY_ISSUED');

        $this->assertEquals(PolicyStatus::ISSUED, $policy->fresh()->status);
    }

    /**
     * Test 9: Read endpoint returns full audit trail, attempts, and references.
     */
    public function test_read_endpoint_returns_complete_audit_trail_and_attempts(): void
    {
        $payload = [
            'client_request_id' => 'AGT-AUDIT-001',
            'agent_id' => 'AGENT-77',
            'customer_name' => 'Tony Stark',
            'date_of_birth' => '1975-05-29',
            'destination' => 'DOMESTIC',
            'trip_start' => '2026-12-01',
            'trip_end' => '2026-12-05',
            'plan_code' => 'PREMIUM',
            'sum_insured' => 500000,
        ];

        $intake = $this->postJson('/api/policy-requests', $payload);
        $policyId = $intake->json('data.id');

        // Submit issuance
        $this->postJson("/api/policy-requests/{$policyId}/submit", ['scenario' => 'SUCCESS']);

        // Query read endpoint
        $read = $this->getJson("/api/policy-requests/{$policyId}");

        $read->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'id',
                    'client_request_id',
                    'agent_id',
                    'customer_name',
                    'calculated_premium',
                    'pricing_breakdown',
                    'status',
                    'policy_number',
                    'provider_reference',
                    'attempts',
                    'audit_trail',
                ],
            ]);

        $this->assertNotEmpty($read->json('data.audit_trail'));
        $this->assertNotEmpty($read->json('data.attempts'));
    }
}
