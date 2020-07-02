<?php

namespace Wincash\CoinPayment\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Wincash\CoinPayment\Console\InstallationCommand;
use Wincash\CoinPayment\Helpers\CoinPaymentHelper;

class CoinPaymentServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot() {
        $this->registerCommand();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('Wincashpay', function(){
            return new CoinPaymentHelper;
        });
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig() {

        
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('wincashpay.php'),
            /**
             * Publishing assets
             */
            __DIR__.'/../Resources/assets/prod/css/wincashpay.css' => public_path('css/wincashpay.css'),
            __DIR__.'/../Resources/assets/prod/js/wincashpay.js' => public_path('js/wincashpay.js'),
            __DIR__.'/../Resources/assets/images' => public_path('/'),
            /**
             * Publishing Jobs
             *
             */
            __DIR__.'/../Jobs/CoinpaymentListener.php' => app_path('jobs/CoinpaymentListener.php'),
        ], 'wincashpay');

        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'wincashpay'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/wincashpay');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/wincashpay';
        }, \Config::get('view.paths')), [$sourcePath]), 'wincashpay');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/wincashpay');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'wincashpay');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'wincashpay');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function registerCommand () {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallationCommand::class
            ]);
        }
    }

}
