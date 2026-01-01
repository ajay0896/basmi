<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MLServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// test route
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working!']);
});

// Spam Detection Routes
Route::prefix('spam-check')->group(function () {
    Route::post('/single', [ReportController::class, 'check']);
    Route::post('/batch', [ReportController::class, 'checkBatch']);
});

// ML Service Monitoring Routes
Route::prefix('ml-service')->group(function () {
    Route::get('/health', [MLServiceController::class, 'health']);
    Route::get('/stats', [MLServiceController::class, 'stats']);
    Route::get('/model-info', [MLServiceController::class, 'modelInfo']);
    Route::post('/test', [MLServiceController::class, 'testPrediction']);
    Route::post('/test-batch', [MLServiceController::class, 'testBatch']);
});

// Legacy route (backward compatibility)
Route::post('/check-text', [ReportController::class, 'check']);
