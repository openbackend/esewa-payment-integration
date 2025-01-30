<?php

namespace Rbb\ESewaPayment\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ESewaPaymentService
{
    public function generatePaymentUrl($amount, $orderId)
    {
        $merchantCode = config('esewa.merchant_code');
        $apiKey = config('esewa.api_key');
        $apiPassword = config('esewa.api_password');

        $params = [
            'amt' => $amount,
            'scd' => $merchantCode,
            'pid' => $orderId,
            'url' => config('esewa.callback_url'),
            'su' => config('esewa.success_url'),
            'fu' => config('esewa.failed_url'),
        ];

        // Construct the eSewa payment URL
        return "https://www.esewa.com.np/epay/main?" . http_build_query($params);
    }

    public function verifyPayment($data)
    {
        // Example verification logic (simplified)
        $amount = $data['amt'];
        $orderId = $data['pid'];
        $responseCode = $data['respcd'];

        if ($responseCode === '0000') {
            // Handle success (store order payment status, etc.)
            return true;
        }

        return false;
    }
}
