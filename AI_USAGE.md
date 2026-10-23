# AI Usage Disclosure (AI_USAGE.md)

This document complies with Section 10 of the TRIPPERSSHIELD Campus Engineering Challenge assignment guidelines.

---

### 1. Tools Used
- **Antigravity AI (Pair Programming Assistant)**
- **PHP CLI / Artisan Test Tooling & Automation**

---

### 2. Concrete Ways AI Assisted the Implementation
1. **Deterministic Pricing Engine Verification**:
   - Implemented and verified the mathematical formula for decimal-safe insurance pricing (`base_rate × days × age_multiplier × destination_multiplier × coverage_multiplier`).
   - Verified the exact sample calculation from the assignment: `20 × 5 × 1.00 × 1.80 × 1.25 = ₹225.00` using BCMath.
2. **State Transition Graph & Concurrency Idempotency**:
   - Structured the strict finite state machine (`RECEIVED` → `VALIDATED` → `SUBMITTED` → `PENDING_CONFIRMATION` / `ISSUED` / `FAILED` / `NEEDS_RECONCILIATION`) with explicit rejection of regressions (e.g. `ISSUED` cannot transition to `SUBMITTED` or `FAILED`).
   - Formulated the database-level compound unique constraint `UNIQUE(agent_id, client_request_id)` combined with transactional `lockForUpdate` and exception fallback to protect against near-simultaneous duplicate intake requests.
3. **PolicyBazaar-Inspired User Interface & Operations Dashboard**:
   - Designed and built the single-page application matching PolicyBazaar's travel insurance landing page aesthetic (popular destination pill selectors, date picker, real-time formula breakdown, and a live reliability sandbox to test all 5 mock insurer failure/timeout/callback scenarios).

---

### 3. Incorrect or Incomplete Suggestion Encountered & Remediation
- **Encountered Issue**:
  - During the initial implementation of `Carbon::parse($dob)->diffInYears($tripStart)` in `PremiumCalculator.php`, the method returned a floating-point number (`28.58...`) under Carbon 3 / PHP 8.5, which triggered a deprecation notice: `Implicit conversion from float to int loses precision`.
- **Remediation**:
  - Corrected the age calculation to use native `DateInterval` calendar difference: `$birthDate->diff($startDate)->y`.
  - This guarantees a deterministic integer age on the trip start date without float precision loss or deprecation warnings, ensuring exact compliance with the age bands (`0–17`, `18–60`, `61–70`, `71+`).

---

### 4. How Output Was Tested and Verified
- **Automated Feature Tests**:
  - Executed full PHPUnit test suite (`php artisan test`) with 11 tests and 78 assertions verifying valid intake, date logic rejection, unsupported plan rejection, duplicate intake prevention, mock insurer timeouts, reconciliation recovery, duplicate callback idempotency, safe retries, and state transition locks.
- **Browser Subagent End-to-End Visual Testing**:
  - Validated the landing page interface, real-time pricing recalculations, plan comparisons, and operational console in the browser via automated browser subagent.
- **cURL Integration Verification**:
  - Validated all REST endpoints via sample cURL requests in `examples/sample_requests.sh`.
