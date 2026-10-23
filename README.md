# TRIPPERSSHIELD - Travel Insurance PolicyFlow Engine

> **Campus Engineering Challenge • Candidate Assignment • Version 1.0**  
> Built with PHP 8.5+, Laravel 12, MySQL 8+ / SQLite, REST API, Automated Test Suite, and a PolicyBazaar-inspired Web Application & Operations Dashboard.

---

## 1. System Overview & Architecture

**TrippersShield** is an idempotent travel insurance distribution engine that handles policy purchase requests from agents, deterministically prices policies, safely coordinates issuance with an unreliable external mock insurer, and provides operational visibility through audit trails and state reconciliation.

### Architecture Diagram

```
+-----------------------------------------------------------------------------------+
|                            TrippersShield Engine                                  |
|                                                                                   |
|  +--------------------+     +---------------------+     +----------------------+  |
|  |  Policy Intake     | --> | Deterministic       | --> | Issuance Workflow    |  |
|  |  Controller & API  |     | Pricing Calculator  |     | State Machine        |  |
|  +--------------------+     +---------------------+     +----------------------+  |
|            |                                                       |              |
|            v                                                       v              |
|  +--------------------+                                 +----------------------+  |
|  | Database Table:    |                                 | Mock Insurer Gateway |  |
|  | policy_requests    |                                 | (Simulated Insurer)  |  |
|  | UNIQUE(agent_id,   |                                 +----------------------+  |
|  | client_request_id) |                                            |              |
|  +--------------------+                                            |              |
|            |                                                       v              |
|            +------------------------------------------- +----------------------+  |
|                                                         | Reliability Handlers |  |
|                                                         | - Timeouts & Reconcil|  |
|                                                         | - Duplicate Callbacks|  |
|                                                         | - Retries & Backoff  |  |
|                                                         +----------------------+  |
+-----------------------------------------------------------------------------------+
```

### State Machine Lifecycle

```
[RECEIVED] ---> [VALIDATED] ---> [SUBMITTED] ---> [ISSUED] (Terminal State)
                    |                |
                    |                +----------> [PENDING_CONFIRMATION] ---> [ISSUED]
                    |                |
                    |                +----------> [NEEDS_RECONCILIATION] ---> [ISSUED] / [VALIDATED]
                    |                |
                    v                v
                 [FAILED] <----------+
                    |
                    +--- (Safe Retry) ---> [SUBMITTED]
```

---

## 2. Duplicate Prevention & Idempotency Strategy

1. **Intake Layer (Compound Database Key)**:
   - Enforced at the relational database schema level via `UNIQUE(agent_id, client_request_id)`.
   - Concurrency protection: Wrapped in atomic `DB::transaction()` using `lockForUpdate()`. Any race condition or duplicate submission returns `HTTP 200 OK` with the existing request snapshot (`is_duplicate: true`) instead of creating a second logical request.
2. **Provider Submission Layer**:
   - Each attempt generates a unique idempotency key: `IDEM-{policy_id}-ATTEMPT-{attempt_number}-{hash}`.
   - If a policy is already `ISSUED`, submission calls return the existing policy number immediately without re-calling the provider.
3. **Provider Callback Layer**:
   - Provider webhooks are tracked in the `provider_events` table with a `UNIQUE(event_id)` constraint.
   - Repeated callbacks return `HTTP 200 OK` (`ALREADY_PROCESSED`) without duplicating state transitions or overwriting confirmed states.
4. **State Transition Immutability**:
   - State regressions out of `ISSUED` (e.g. `ISSUED -> SUBMITTED` or `ISSUED -> FAILED`) are strictly rejected with `InvalidStateTransitionException` (HTTP 409).

---

## 3. Implemented Reliability Scenarios (All 4 Cases)

| Scenario | Description & Handling Strategy | Automated Test Coverage |
| :--- | :--- | :--- |
| **1. Duplicate Intake** | Repeated or near-simultaneous submissions with same `agent_id` + `client_request_id` return `200 OK` with existing record; no duplicate row created. | `test_repeated_agent_and_client_request_id_does_not_create_duplicate_request` |
| **2. Timeout After Success** | Insurer creates policy internally, but HTTP client call times out (`504 Gateway Timeout`). Request transitions to `NEEDS_RECONCILIATION`. Blind reissue is blocked. Reconciliation endpoint queries insurer status and safely transitions to `ISSUED`. | `test_timeout_after_success_and_reconciliation_recovery` |
| **3. Duplicate Callback** | The same provider event is delivered multiple times (e.g. 3x webhook delivery). Processing is deduplicated using `provider_events.event_id`, returning `ALREADY_PROCESSED` without duplicate state changes. | `test_duplicate_callback_is_safely_idempotent` |
| **4. Retry After Temporary Failure** | First submission receives retriable error (`503 Service Unavailable`). Marked as `FAILED`. Subsequent authorized retry uses original immutable pricing snapshot and issues policy cleanly. | `test_retry_after_temporary_failure_preserves_premium_and_succeeds` |

---

## 4. Local Setup & Execution Guide

### Prerequisites
- **PHP**: 8.2+ (Developed & tested on PHP 8.5.12)
- **Composer**: 2.x
- **Database**: SQLite (default zero-dependency) or MySQL 8+ / PostgreSQL

### Setup Steps

```bash
# 1. Clone repository
git clone <repository_url>
cd <repository_folder>

# 2. Install dependencies
composer install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Run migrations
php artisan migrate

# 5. Start the local server
php artisan serve --port=8000
```

The application and interactive UI will be accessible at `http://127.0.0.1:8000`.

---

## 5. Running Automated Tests

Run the full automated test suite covering all business rules and reliability scenarios:

```bash
php artisan test
```

Expected output:
```
PASS  Tests\Feature\PolicyEngineTest
✓ valid request produces expected premium and status
✓ invalid travel dates and unsupported plan are rejected
✓ repeated agent and client request id does not create duplicate request
✓ successful provider response produces exactly one policy number
✓ timeout after success and reconciliation recovery
✓ duplicate callback is safely idempotent
✓ retry after temporary failure preserves premium and succeeds
✓ cannot overwrite confirmed issued state
✓ read endpoint returns complete audit trail and attempts

Tests:    11 passed (78 assertions)
Duration: 0.18s
```

---

## 6. API Contract Reference

### 6.1 Policy Request Intake
- **Endpoint**: `POST /api/policy-requests`
- **Headers**: `Content-Type: application/json`, `Accept: application/json`
- **Request Body**:
```json
{
  "client_request_id": "AGT-2026-0001",
  "agent_id": "AGENT-17",
  "customer_name": "Sample Customer",
  "date_of_birth": "1998-04-10",
  "destination": "INTERNATIONAL",
  "trip_start": "2026-11-10",
  "trip_end": "2026-11-14",
  "plan_code": "PLUS",
  "sum_insured": 300000
}
```
- **Responses**:
  - `HTTP 201 Created`: New request successfully ingested and validated.
  - `HTTP 200 OK`: Existing request safely returned (idempotent).
  - `HTTP 422 Unprocessable Content`: Validation failure with field errors.

### 6.2 Retrieve Policy Details & Audit Trail
- **Endpoint**: `GET /api/policy-requests/{id}`
- **Response**: Returns pricing breakdown, status, policy number, provider reference, attempt logs, and full state history audit trail.

### 6.3 Submit for Issuance
- **Endpoint**: `POST /api/policy-requests/{id}/submit`
- **Body / Header**: `{"scenario": "SUCCESS"}` (Supported: `SUCCESS`, `TEMPORARY_FAILURE`, `TIMEOUT_AFTER_ISSUE`, `DELAYED_CALLBACK`, `DUPLICATE_CALLBACK`).

### 6.4 Provider Webhook Callback
- **Endpoint**: `POST /api/mock-insurer/callback`
- **Body**:
```json
{
  "event_id": "EVT-2026-9901",
  "event_type": "POLICY_ISSUED",
  "provider_reference": "REF-ABC12345",
  "client_request_id": "AGT-2026-0001",
  "policy_number": "POL-2026-XYZ987",
  "status": "ISSUED"
}
```

### 6.5 Operational Reconciliation
- **Endpoint**: `POST /api/policy-requests/{id}/reconcile`
- **CLI Command**: `php artisan policy:reconcile` (scans all pending/timeout policies and reconciles against provider status).

---

## 7. Sample cURL Scripts

Run the bundled executable script to test all endpoints end-to-end:
```bash
./examples/sample_requests.sh
```

---

## 8. Web User Interface

The application features a PolicyBazaar-inspired web UI matching the visual design requirements:
- Search destination country with quick pills (Domestic India, Schengen, USA, UAE, Germany, UK, Thailand).
- Live real-time pricing calculator showing the exact deterministic formula breakdown.
- Plan comparison cards for **BASIC** (₹12/day), **PLUS** (₹20/day), and **PREMIUM** (₹30/day).
- Mock Insurer Reliability Test Sandbox with scenario switcher.
- Real-time Operations Console displaying state transitions, attempt logs, and requests table.

---

## 9. Known Assumptions & Limitations
1. **Mock Insurer Storage**: Insurer state is simulated locally using the `mock_provider_policies` table to ensure deterministic test execution without external network latency.
2. **Date of Birth**: Age is calculated on the trip start date using integer calendar difference (`$dob->diff($tripStart)->y`).
3. **Queue Processing**: Synchronous database transactions are used as the primary consistency mechanism. For asynchronous queue processing with Redis/Horizon, events can be dispatched onto jobs with exponential backoff.
