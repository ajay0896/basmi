<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * SpamDetectionService - Interface to ML API for spam detection
 *
 * Connects to Python ML service for text validation
 * Features: single prediction, batch prediction, health check, stats
 *
 * @version 2.0.0
 */
class SpamDetectionService
{
    protected $baseUrl;
    protected $timeout;
    protected $confidenceThreshold;

    /**
     * Initialize service with config values
     */
    public function __construct()
    {
        $this->baseUrl = config('ml_service.base_url', 'http://127.0.0.1:8001');
        $this->timeout = config('ml_service.timeout', 10);
        $this->confidenceThreshold = config('ml_service.confidence_threshold', 0.6);
    }

    /**
     * Check single text for spam
     *
     * @param string $text Text to check
     * @return array Response with success, prediction, label, confidence, etc.
     */
    public function checkText(string $text): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->asJson()
                ->post($this->baseUrl . '/predict', [
                    'text' => $text
                ]);

            if ($response->failed()) {
                $status = $response->status();
                $body = $response->json();

                // Handle 422 Validation Error
                if ($status === 422) {
                    Log::warning('ML API validation error', [
                        'status' => $status,
                        'error' => $body,
                        'text_length' => strlen($text)
                    ]);

                    // Extract validation error message
                    $errorMsg = 'Text tidak memenuhi kriteria validasi';
                    if (isset($body['detail']) && is_array($body['detail'])) {
                        $errorMsg = $body['detail'][0]['msg'] ?? $errorMsg;
                    }

                    return [
                        'success' => false,
                        'error' => $errorMsg,
                        'prediction' => 0,
                        'label' => 'validation_error',
                        'confidence' => 0
                    ];
                }

                Log::error('ML API request failed', [
                    'status' => $status,
                    'body' => $body
                ]);

                return [
                    'success' => false,
                    'error' => 'ML service unavailable',
                    'prediction' => 0,
                    'label' => 'unknown',
                    'confidence' => 0
                ];
            }

            $result = $response->json();

            // Log low confidence predictions
            if (isset($result['confidence']) && $result['confidence'] < $this->confidenceThreshold) {
                Log::warning('Low confidence ML prediction', [
                    'text_preview' => substr($text, 0, 50),
                    'confidence' => $result['confidence'],
                    'label' => $result['label'] ?? 'unknown'
                ]);
            }

            return $result;

        } catch (Exception $e) {
            Log::error('ML API exception', [
                'message' => $e->getMessage(),
                'text_length' => strlen($text)
            ]);

            return [
                'success' => false,
                'error' => 'Connection to ML service failed',
                'prediction' => 0,
                'label' => 'unknown',
                'confidence' => 0
            ];
        }
    }

    /**
     * Check multiple texts in batch (max 10)
     *
     * @param array $texts Array of texts to check
     * @return array Batch response with results array
     */
    public function checkBatch(array $texts): array
    {
        try {
            // Limit to 10 texts
            $texts = array_slice($texts, 0, 10);

            $response = Http::timeout($this->timeout * 2)
                ->asJson()
                ->post($this->baseUrl . '/predict/batch', [
                    'texts' => $texts
                ]);

            if ($response->failed()) {
                Log::error('ML API batch request failed', [
                    'status' => $response->status(),
                    'count' => count($texts)
                ]);

                return [
                    'success' => false,
                    'error' => 'Batch prediction failed'
                ];
            }

            return $response->json();

        } catch (Exception $e) {
            Log::error('ML API batch exception', [
                'message' => $e->getMessage(),
                'count' => count($texts)
            ]);

            return [
                'success' => false,
                'error' => 'Batch prediction connection failed'
            ];
        }
    }

    /**
     * Check ML service health
     *
     * @return array Health status response
     */
    public function healthCheck(): array
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl . '/health');

            if ($response->successful()) {
                return array_merge($response->json(), ['reachable' => true]);
            }

            return ['reachable' => false, 'status' => 'unhealthy'];

        } catch (Exception $e) {
            return [
                'reachable' => false,
                'status' => 'unreachable',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get ML service statistics
     *
     * @return array Stats response
     */
    public function getStats(): array
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl . '/stats');

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'Could not fetch stats'];

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get ML model information
     *
     * @return array Model info response
     */
    public function getModelInfo(): array
    {
        try {
            $response = Http::timeout(5)->get($this->baseUrl . '/model-info');

            if ($response->successful()) {
                return $response->json();
            }

            return ['error' => 'Could not fetch model info'];

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Check if confidence is acceptable
     *
     * @param float $confidence Confidence score
     * @return bool True if confidence meets threshold
     */
    public function isConfident(float $confidence): bool
    {
        return $confidence >= $this->confidenceThreshold;
    }
}
