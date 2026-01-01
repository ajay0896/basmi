<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ML Service Base URL
    |--------------------------------------------------------------------------
    |
    | Base URL untuk ML service API. Default: http://127.0.0.1:8001
    |
    */
    'base_url' => env('ML_API_URL', 'http://127.0.0.1:8001'),

    /*
    |--------------------------------------------------------------------------
    | Request Timeout
    |--------------------------------------------------------------------------
    |
    | Timeout untuk HTTP requests ke ML service (dalam detik)
    |
    */
    'timeout' => env('ML_TIMEOUT', 10),

    /*
    |--------------------------------------------------------------------------
    | Confidence Threshold
    |--------------------------------------------------------------------------
    |
    | Minimum confidence score untuk menerima prediksi ML (0.0 - 1.0)
    | Predictions dengan confidence di bawah threshold akan di-log sebagai warning
    |
    */
    'confidence_threshold' => env('ML_CONFIDENCE_THRESHOLD', 0.6),

    /*
    |--------------------------------------------------------------------------
    | Batch Size Limit
    |--------------------------------------------------------------------------
    |
    | Maximum number of texts untuk batch prediction
    |
    */
    'batch_limit' => 10,

    /*
    |--------------------------------------------------------------------------
    | Retry Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration untuk retry logic jika ML service unavailable
    |
    */
    'retry' => [
        'enabled' => env('ML_RETRY_ENABLED', true),
        'times' => env('ML_RETRY_TIMES', 2),
        'sleep' => env('ML_RETRY_SLEEP', 100), // milliseconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Behavior
    |--------------------------------------------------------------------------
    |
    | Apa yang dilakukan jika ML service tidak available
    | Options: 'reject' (reject laporan), 'allow' (allow laporan), 'manual' (flag untuk review manual)
    |
    */
    'fallback_on_error' => env('ML_FALLBACK_BEHAVIOR', 'manual'),

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Enable/disable detailed logging untuk ML predictions
    |
    */
    'log_predictions' => env('ML_LOG_PREDICTIONS', true),
    'log_errors' => env('ML_LOG_ERRORS', true),

];
