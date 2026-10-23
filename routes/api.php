<?php

use App\Http\Controllers\Api\MockInsurerController;
use App\Http\Controllers\Api\PolicyRequestController;
use Illuminate\Support\Facades\Route;


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
