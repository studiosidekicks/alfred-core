<?php

namespace  Studiosidekicks\Alfred\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Providers\BackAuthServiceProvider;
use Studiosidekicks\Alfred\Commands\SetupPrimaryAccount;
use Studiosidekicks\Alfred\Auth\Front\Facades\FrontAuth;
use Studiosidekicks\Alfred\Auth\Front\Services\FrontAuthService;

class AlfredProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerOtherProviders();
        $this->registerCommands();

        $this->prepareResources();
        $this->registerFrontAuth();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Publish config
        $config = realpath(__DIR__ . '/../../config/config.php');
        $this->mergeConfigFrom($config, 'studiosidekicks.alfred');

        $this->publishes([
            $config => config_path('studiosidekicks.alfred.php'),
        ], 'config');

        // Publish migrations
        $migrations = realpath(__DIR__ . '/../../database/migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/alfred'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [];
    }

    private function registerOtherProviders()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BackAuthServiceProvider::class);
    }

    private function registerFrontAuth()
    {
        $config = config('studiosidekicks.alfred');

        if (!empty($config['auth']['front']['is_enabled'])) {
            $this->app->singleton('studiosidekicks.alfred.front_auth', function ($app) use ($config) {
                return new FrontAuthService($config['auth']['front']['model']);
            });

            $this->app->alias('FrontAuth', FrontAuth::class);

        }
    }

    private function registerCommands()
    {
        $this->commands([
            SetupPrimaryAccount::class
        ]);
    }
}
