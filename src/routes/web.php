<?php

use Illuminate\Support\Facades\Route;
use Rbb\ESewaPayment\Controllers\ESewaPaymentController;

Route::group(['prefix' => 'esewa', 'as' => 'esewa.'], function () {
    // Payment initiation
    Route::post('payment', [ESewaPaymentController::class, 'initiatePayment'])->name('payment');
    // Callback from eSewa
    Route::post('callback', [ESewaPaymentController::class, 'handleCallback'])->name('callback');
    // Success and failure GET routes (for browser redirects)
    Route::get('success', [ESewaPaymentController::class, 'paymentSuccess'])->name('success');
    Route::get('failure', [ESewaPaymentController::class, 'paymentFailure'])->name('failure');
});
