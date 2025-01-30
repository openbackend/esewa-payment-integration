<?php

use Illuminate\Support\Facades\Route;
use Rudraramesh\ESewaPayment\Controllers\ESewaPaymentController;

Route::post('esewa/payment', [ESewaPaymentController::class, 'initiatePayment']);
Route::post('esewa/callback', [ESewaPaymentController::class, 'handleCallback']);
