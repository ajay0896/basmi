<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SpamDetectionService;

/**
 * ReportController - Handle spam checking untuk reports
 */
class ReportController extends Controller
{
    protected $spamService;

    public function __construct(SpamDetectionService $spamService)
    {
        $this->spamService = $spamService;
    }

    /**
     * Check single text for spam
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request)
    {
        $request->validate([
            'text' => 'required|string|min:20|max:5000'
        ]);

        $result = $this->spamService->checkText($request->text);

        // Add additional metadata
        return response()->json([
            'data' => $result,
            'is_confident' => isset($result['confidence'])
                ? $this->spamService->isConfident($result['confidence'])
                : false,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Check multiple texts in batch
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkBatch(Request $request)
    {
        $request->validate([
            'texts' => 'required|array|min:1|max:10',
            'texts.*' => 'required|string|min:20|max:5000'
        ]);

        $result = $this->spamService->checkBatch($request->texts);

        return response()->json([
            'data' => $result,
            'timestamp' => now()->toIso8601String()
        ]);
    }
}
