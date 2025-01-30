# eSewa Payment Integration for Laravel


A simple and easy-to-use Laravel package to integrate the eSewa payment gateway into your application. This package handles payment initiation, transaction verification, and success or failure responses using eSewa, a leading payment gateway in Nepal.


## Features
    * Easily integrate the eSewa payment gateway into your Laravel project.
    * Supports payment initiation, transaction verification, and callback handling.
    * Simple configuration with environment variables for secure API keys.
    * Compatible with Laravel 7.x, 8.x, and higher.

## Installation
1.  Install the Package:
    You can install the package via Composer. In your Laravel project directory, run:
    ```bash
    composer require rudraramesh/esewa-payment

2. Publish Configuration File
   ```bash
   php artisan vendor:publish --provider="Rudraramesh\EsewaPayment\Providers\ESewaPaymentServiceProvider" --tag=config

3. Add Configuration to .env
   ```bash
    ESewa_MERCHANT_CODE=your_merchant_code
    ESewa_API_KEY=your_api_key
    ESewa_API_PASSWORD=your_api_password
    ESewa_SUCCESS_URL=http://your-site.com/success
    ESewa_FAILED_URL=http://your-site.com/failed
    ESewa_CALLBACK_URL=http://your-site.com/callback

# Configuration File
The package will use the config/esewa.php configuration file to manage settings like the merchant code, API credentials, and URLs for payment success, failure, and callback.
    ```bash
    
    return [
        'merchant_code' => env('ESewa_MERCHANT_CODE'),
        'api_key' => env('ESewa_API_KEY'),
        'api_password' => env('ESewa_API_PASSWORD'),
        'success_url' => env('ESewa_SUCCESS_URL'),
        'failed_url' => env('ESewa_FAILED_URL'),
        'callback_url' => env('ESewa_CALLBACK_URL'),
    ]
         
# Usage

## step 1. Add Routes
Add the routes to your routes/web.php file. These routes will handle the payment initiation and callback from eSewa.
    ```bash

    use Rudraramesh\EsewaPayment\Controllers\ESewaPaymentController;

    Route::get('initiate-payment', [ESewaPaymentController::class, 'initiatePayment']);
    Route::get('payment-callback', [ESewaPaymentController::class, 'paymentCallback']);

## step 2. Create Controller for Payment Integration
In your Laravel controller, you can initiate the payment process and handle the callback like so:
        ```bash

        namespace App\Http\Controllers;

        use Rudraramesh\EsewaPayment\Controllers\ESewaPaymentController;
        use Illuminate\Http\Request;

        class PaymentController extends Controller
        {
            public function initiatePayment(Request $request)
            {
                // Here, you can call your payment initiation logic
                return (new ESewaPaymentController())->initiatePayment($request);
            }

            public function paymentCallback(Request $request)
            {
                // Handle the callback from eSewa for payment success/failure
                return (new ESewaPaymentController())->paymentCallback($request);
            }
        }

## step 3. Handle Payment Initiation
The ESewaPaymentController includes a method for initiating the payment:
    ```bash
    public function initiatePayment(Request $request)
    {
        // Retrieve merchant code from config
        $merchantCode = config('eseva.merchant_code');
        // For example, setting up the payment URL, redirecting, etc.

        return redirect()->route('success');
    }

## step 4. Handle Payment Callback

Once the payment is completed (or fails), eSewa will send a callback to the provided callback URL. You can handle the callback response like so:
    ```bash

    public function paymentCallback(Request $request)
    {
        // Handle eSewa payment callback, verify payment, and update your system.
        // Process success/failure and respond accordingly.

        return response()->json(['status' => 'success']);
    }


# Testing
You can test the eSewa payment integration by initiating a payment using the /initiate-payment route, and then eSewa will redirect to the success or failure URL based on the payment outcome.

You can also test the callback functionality by simulating a callback to the /payment-callback route.


# Notes
* Make sure that the API keys and merchant credentials are correct and set in the .env file.
* You can customize the logic in the ESewaPaymentController to fit your payment workflow.
* The package assumes youre handling both success and failure URLs on your site and can manage the response accordingly.
* This package is compatible with Laravel versions 7.x, 8.x, and above.


# Contributing
If you want to contribute to the development of this package, feel free to fork the repository and create pull requests. Make sure to follow best practices and write tests if youre adding new features.


# License
This package is open-sourced under the MIT License. See the LICENSE file for more information.



