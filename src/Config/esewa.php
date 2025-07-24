<?php

return [
    // eSewa environment: 'sandbox' or 'live'
    'environment' => env('ESEWA_ENVIRONMENT', 'sandbox'),

    // eSewa endpoints
    'endpoints' => [
        'sandbox' => 'https://uat.esewa.com.np/epay/main',
        'live' => 'https://www.esewa.com.np/epay/main',
    ],

    'merchant_code' => env('ESEWA_MERCHANT_CODE', ''),
    'api_key' => env('ESEWA_API_KEY', ''),
    'api_password' => env('ESEWA_API_PASSWORD', ''),
    'success_url' => env('ESEWA_SUCCESS_URL', ''),
    'failed_url' => env('ESEWA_FAILED_URL', ''),
    'callback_url' => env('ESEWA_CALLBACK_URL', ''),
];
