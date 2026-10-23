<?php

use App\Http\Controllers\Api\MockInsurerController;
use App\Http\Controllers\Api\PolicyRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| TrippersShield Travel Insurance API Routes
|--------------------------------------------------------------------------
| Minimum API Contract:
| POST /api/policy-requests              Create or safely return existing request
| GET  /api/policy-requests/{id}         Retrieve status, premium, and references
| POST /api/policy-requests/{id}/submit  Start or safely resume issuance
| POST /api/mock-insurer/callback        Receive a simulated provider event
| GET  /api/policy-requests              List requests with status filter and pagination
|
| Extended Operational Endpoints:
| POST /api/policy-requests/{id}/reconcile Reconcile timeout/pending state
| GET  /api/mock-insurer/status/{id}       Mock insurer status lookup
| POST /api/mock-insurer/trigger-callback  Simulate provider callback for testing
*/

Route::prefix('policy-requests')->group(function () {
    Route::post('/', [PolicyRequestController::class, 'store']);
    Route::get('/', [PolicyRequestController::class, 'index']);
    Route::get('/{id}', [PolicyRequestController::class, 'show']);
    Route::post('/{id}/submit', [PolicyRequestController::class, 'submit']);
    Route::post('/{id}/reconcile', [PolicyRequestController::class, 'reconcile']);
});

Route::prefix('mock-insurer')->group(function () {
    Route::post('/callback', [MockInsurerController::class, 'callback']);
    Route::get('/status/{identifier}', [MockInsurerController::class, 'lookupStatus']);
    Route::post('/trigger-callback', [MockInsurerController::class, 'triggerCallback']);
});
