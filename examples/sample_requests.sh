#!/usr/bin/env bash
# ==============================================================================
# TrippersShield PolicyFlow Engine - Sample cURL Requests
# ==============================================================================

BASE_URL="http://127.0.0.1:8000"

echo "=========================================================="
echo "1. POST /api/policy-requests (Intake New Policy Request)"
echo "=========================================================="
curl -s -X POST "${BASE_URL}/api/policy-requests" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "client_request_id": "AGT-2026-0001",
    "agent_id": "AGENT-17",
    "customer_name": "Sample Customer",
    "date_of_birth": "1998-04-10",
    "destination": "INTERNATIONAL",
    "trip_start": "2026-11-10",
    "trip_end": "2026-11-14",
    "plan_code": "PLUS",
    "sum_insured": 300000
  }' | jq .

echo ""
echo "=========================================================="
echo "2. POST /api/policy-requests (Duplicate Intake Test - 200 OK)"
echo "=========================================================="
curl -s -X POST "${BASE_URL}/api/policy-requests" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "client_request_id": "AGT-2026-0001",
    "agent_id": "AGENT-17",
    "customer_name": "Sample Customer",
    "date_of_birth": "1998-04-10",
    "destination": "INTERNATIONAL",
    "trip_start": "2026-11-10",
    "trip_end": "2026-11-14",
    "plan_code": "PLUS",
    "sum_insured": 300000
  }' | jq .

echo ""
echo "=========================================================="
echo "3. POST /api/policy-requests/1/submit (Submit Issuance: SUCCESS)"
echo "=========================================================="
curl -s -X POST "${BASE_URL}/api/policy-requests/1/submit" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"scenario": "SUCCESS"}' | jq .

echo ""
echo "=========================================================="
echo "4. GET /api/policy-requests/1 (Read Details & Full Audit Trail)"
echo "=========================================================="
curl -s -X GET "${BASE_URL}/api/policy-requests/1" \
  -H "Accept: application/json" | jq .

echo ""
echo "=========================================================="
echo "5. GET /api/policy-requests (List Requests with Status Filter)"
echo "=========================================================="
curl -s -X GET "${BASE_URL}/api/policy-requests?status=ISSUED&per_page=10" \
  -H "Accept: application/json" | jq .

echo ""
echo "=========================================================="
echo "6. POST /api/mock-insurer/callback (Simulated Callback Event)"
echo "=========================================================="
curl -s -X POST "${BASE_URL}/api/mock-insurer/callback" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "event_id": "EVT-MOCK-SAMPLE-001",
    "event_type": "POLICY_ISSUED",
    "provider_reference": "REF-SAMPLE123",
    "client_request_id": "AGT-2026-0001",
    "policy_number": "POL-2026-SAMPLE01",
    "status": "ISSUED"
  }' | jq .

echo ""
echo "=========================================================="
echo "7. GET /api/mock-insurer/status/AGT-2026-0001 (Provider Status Lookup)"
echo "=========================================================="
curl -s -X GET "${BASE_URL}/api/mock-insurer/status/AGT-2026-0001" \
  -H "Accept: application/json" | jq .
