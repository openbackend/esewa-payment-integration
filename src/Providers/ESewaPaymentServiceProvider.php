<?php

namespace Rbb\ESewaPayment\Providers;

use Illuminate\Support\ServiceProvider;

class ESewaPaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/esewa.php', 'esewa'
        );
    }

    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../Config/esewa.php' => config_path('esewa.php'),
        ]);
    }
}
