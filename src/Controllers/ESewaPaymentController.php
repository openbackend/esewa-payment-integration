<?php

namespace Rbb\ESewaPayment\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Rbb\ESewaPayment\Services\ESewaPaymentService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ESewaPaymentController extends Controller
{
    protected $paymentService;

    public function __construct(ESewaPaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function initiatePayment(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|string|max:255',
        ]);

        try {
            $paymentUrl = $this->paymentService->generatePaymentUrl(
                $validated['amount'],
                $validated['order_id']
            );
            return redirect($paymentUrl);
        } catch (\Exception $e) {
            Log::error('eSewa payment initiation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Payment initiation failed.'], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $result = $this->paymentService->verifyPayment($request->all());
            if ($result) {
                // Fire event for extensibility
                Event::dispatch('esewa.payment.success', [$request->all()]);
                return redirect(config('esewa.success_url'));
            } else {
                Event::dispatch('esewa.payment.failed', [$request->all()]);
                return redirect(config('esewa.failed_url'));
            }
        } catch (\Exception $e) {
            Log::error('eSewa callback handling failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Callback handling failed.'], 500);
        }
    }

    // Optionally, add GET handlers for success/failure if needed
    public function paymentSuccess(Request $request)
    {
        return view('esewa-payment::success');
    }

    public function paymentFailure(Request $request)
    {
        return view('esewa-payment::failure');
    }
}
