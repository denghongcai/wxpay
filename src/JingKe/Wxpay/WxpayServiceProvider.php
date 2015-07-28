<?php namespace JingKe\Wxpay;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class WxpayServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application events.
    *
    * @return void
    */
    public function boot()
    {
        $configPath = __DIR__ . '/../../config/wxpay.php';
        $this->publishes([$configPath => config_path('wxpay.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;
        $app['wxpay'] = $app->share(function ($app) {
            return new Wxpay(config("wxpay",[]));
        });
    }
}
