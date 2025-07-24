<?php

namespace Rbb\ESewaPayment\Providers;

use Illuminate\Support\ServiceProvider;
use function config_path;

class ESewaPaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/esewa.php', 'esewa'
        );

        // Bind the payment service for easier customization
        $this->app->singleton(\Rbb\ESewaPayment\Services\ESewaPaymentService::class, function ($app) {
            return new \Rbb\ESewaPayment\Services\ESewaPaymentService();
        });
    }

    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../Config/esewa.php' => config_path('esewa.php'),
        ], 'config');

        // Publish views
        $this->publishes([
            __DIR__.'/../views' => resource_path('views/vendor/esewa-payment'),
        ], 'views');

        // Load package routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load views from package
        $this->loadViewsFrom(__DIR__.'/../views', 'esewa-payment');
    }
}
