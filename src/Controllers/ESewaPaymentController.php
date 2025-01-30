<?php

namespace Rbb\ESewaPayment\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rbb\ESewaPayment\Services\ESewaPaymentService;

class ESewaPaymentController extends Controller
{
    protected $paymentService;

    public function __construct(ESewaPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function initiatePayment(Request $request)
    {
        $paymentUrl = $this->paymentService->generatePaymentUrl(
            $request->input('amount'),
            $request->input('order_id')
        );

        return redirect($paymentUrl);
    }

    public function handleCallback(Request $request)
    {
        $result = $this->paymentService->verifyPayment($request->all());

        // Handle the response (save payment status, notify users, etc.)
        return $result ? redirect(config('esewa.success_url')) : redirect(config('esewa.failed_url'));
    }
}
