<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //


        $this->app->singleton('paypal.client', function ($app) {
            $config = config('services.paypal');
            if ($config['mode'] == 'sandbox') {
                $environment = new SandboxEnvironment($config['client_id'], $config['client_secret']);
            } else {
                $environment = new ProductionEnvironment($config['client_id'], $config['client_secret']);
            }
            $client = new PayPalHttpClient($environment);
            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
