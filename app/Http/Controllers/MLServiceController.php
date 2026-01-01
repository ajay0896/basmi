<?php

namespace App\Http\Controllers;

use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * MLServiceController - Endpoints untuk monitoring ML service
 *
 * Provides health check, stats, and model info endpoints
 */
class MLServiceController extends Controller
{
    protected $spamService;

    public function __construct(SpamDetectionService $spamService)
    {
        $this->spamService = $spamService;
    }

    /**
     * Check ML service health status
     *
     * @return JsonResponse
     */
    public function health(): JsonResponse
    {
        $health = $this->spamService->healthCheck();

        $status = $health['reachable'] ?? false ? 200 : 503;

        return response()->json([
            'ml_service' => $health,
            'timestamp' => now()->toIso8601String()
        ], $status);
    }

    /**
     * Get ML service statistics
     *
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        $stats = $this->spamService->getStats();

        return response()->json([
            'ml_stats' => $stats,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Get ML model information
     *
     * @return JsonResponse
     */
    public function modelInfo(): JsonResponse
    {
        $info = $this->spamService->getModelInfo();

        return response()->json([
            'model_info' => $info,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Test single text prediction
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function testPrediction(Request $request): JsonResponse
    {
        $request->validate([
            'text' => 'required|string|min:20|max:5000'
        ]);

        $result = $this->spamService->checkText($request->text);

        return response()->json([
            'result' => $result,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Test batch prediction
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function testBatch(Request $request): JsonResponse
    {
        $request->validate([
            'texts' => 'required|array|min:1|max:10',
            'texts.*' => 'required|string|min:20|max:5000'
        ]);

        $result = $this->spamService->checkBatch($request->texts);

        return response()->json([
            'result' => $result,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}
