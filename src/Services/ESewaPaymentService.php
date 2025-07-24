<?php

namespace Rbb\ESewaPayment\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use function config;

class ESewaPaymentService
{
    public function generatePaymentUrl($amount, $orderId)
    {
        $merchantCode = config('esewa.merchant_code');
        $environment = config('esewa.environment', 'sandbox');
        $endpoint = config('esewa.endpoints.' . $environment);

        $params = [
            'amt' => $amount,
            'scd' => $merchantCode,
            'pid' => $orderId,
            'url' => config('esewa.callback_url'),
            'su' => config('esewa.success_url'),
            'fu' => config('esewa.failed_url'),
        ];

        // Construct the eSewa payment URL
        return $endpoint . '?' . http_build_query($params);
    }

    /**
     * Verify payment with eSewa server (server-to-server verification)
     */
    public function verifyPayment($data)
    {
        $environment = config('esewa.environment', 'sandbox');
        $verifyEndpoint = $environment === 'live'
            ? 'https://www.esewa.com.np/epay/transrec'
            : 'https://uat.esewa.com.np/epay/transrec';

        $params = [
            'amt' => $data['amt'] ?? null,
            'scd' => config('esewa.merchant_code'),
            'pid' => $data['pid'] ?? null,
            'rid' => $data['refId'] ?? $data['rid'] ?? null,
        ];

        try {
            $response = Http::asForm()->post($verifyEndpoint, $params);
            $body = $response->body();
            Log::info('eSewa verification response', ['body' => $body]);

            // eSewa returns XML. Check for <response_code>Success</response_code>
            if (strpos($body, '<response_code>Success</response_code>') !== false) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error('eSewa verification failed', ['error' => $e->getMessage()]);
        }

        return false;
    }
}
