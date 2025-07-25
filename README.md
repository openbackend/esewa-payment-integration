# Laravel eSewa Payment Gateway Integration

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rudraramesh/esewa-payment.svg?style=flat-square)](https://packagist.org/packages/rudraramesh/esewa-payment)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A Laravel package for seamless integration of the [eSewa](https://esewa.com.np) payment gateway, the leading online payment solution in Nepal. Easily accept online payments in your Laravel application using eSewa, with secure server-to-server verification and customizable success/failure pages.

## Features
- Laravel eSewa payment gateway integration
- Supports online payments in Nepal
- Secure server-to-server transaction verification
- Easy configuration and setup
- Customizable success and failure views
- Compatible with Laravel 9, 10, 11, 12 and PHP 7.4, 8.x
- Extensible: fires events on payment success/failure

## Installation
1.  Install the Package:
    ```bash
    composer require rudraramesh/esewa-payment
    ```

2. Publish Configuration and Views
   ```bash
   php artisan vendor:publish --provider="Rbb\ESewaPayment\Providers\ESewaPaymentServiceProvider" --tag=config
   php artisan vendor:publish --provider="Rbb\ESewaPayment\Providers\ESewaPaymentServiceProvider" --tag=views
   ```
   This will copy the config file to `config/esewa.php` and the views to `resources/views/vendor/esewa-payment/` so you can customize them.

3. Add Configuration to .env
   ```env
   ESEWA_ENVIRONMENT=sandbox # or live
   ESEWA_MERCHANT_CODE=your_merchant_code
   ESEWA_API_KEY=your_api_key
   ESEWA_API_PASSWORD=your_api_password
   ESEWA_SUCCESS_URL=https://your-site.com/esewa/success
   ESEWA_FAILED_URL=https://your-site.com/esewa/failure
   ESEWA_CALLBACK_URL=https://your-site.com/esewa/callback
   ```

## Configuration File
The package uses `config/esewa.php` to manage settings like the merchant code, API credentials, environment, and URLs for payment success, failure, and callback.

## Usage

### 1. Routes
The package automatically registers the following routes (with prefix `esewa.`):

| Method | URI                | Name             | Description                  |
|--------|--------------------|------------------|------------------------------|
| POST   | /esewa/payment     | esewa.payment    | Initiate payment             |
| POST   | /esewa/callback    | esewa.callback   | Handle eSewa callback        |
| GET    | /esewa/success     | esewa.success    | Success redirect (optional)  |
| GET    | /esewa/failure     | esewa.failure    | Failure redirect (optional)  |

### 2. Initiate Payment
Send a POST request to `/esewa/payment` with `amount` and `order_id`:

```php
$response = Http::post('/esewa/payment', [
    'amount' => 1000,
    'order_id' => 'ORDER123',
]);
```

Or, from a form:
```html
<form method="POST" action="/esewa/payment">
    @csrf
    <input type="number" name="amount" required />
    <input type="text" name="order_id" required />
    <button type="submit">Pay with eSewa</button>
</form>
```

### 3. Handle Callback
The package will handle the callback from eSewa and perform server-to-server verification. On success/failure, it will redirect to the configured URLs.

### 4. Customizing Views
The package provides default success and failure views that use standalone HTML and Bootstrap for styling. You can customize these views after publishing:
- `resources/views/vendor/esewa-payment/success.blade.php`
- `resources/views/vendor/esewa-payment/failure.blade.php`

You can edit these files to match your application's look and feel. There is **no dependency on any specific layout**.

### 5. Events
Listen for payment events in your application:

```php
Event::listen('esewa.payment.success', function ($payload) {
    // Handle payment success
});
Event::listen('esewa.payment.failed', function ($payload) {
    // Handle payment failure
});
```

## Sandbox/Live Environment
Set `ESEWA_ENVIRONMENT=sandbox` for testing, or `live` for production. The package will use the correct endpoints automatically.

## Error Handling
- Input is validated before initiating payment.
- All errors are logged using Laravel's logger.
- Server-to-server verification is performed for security.

## Links
- [eSewa Official Website](https://esewa.com.np)
- [Packagist Package](https://packagist.org/packages/rudraramesh/esewa-payment)
- [GitHub Repository](https://github.com/RudraRamesh/esewa-payment)
- [Report Issues](https://github.com/RudraRamesh/esewa-payment/issues)

## Contributing
Feel free to fork the repository and create pull requests. Please follow best practices and write tests if you add new features.

## License
This package is open-sourced under the MIT License. See the [LICENSE File](LICENSE) for more information.



