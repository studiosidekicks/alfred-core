<?php

namespace  Studiosidekicks\Alfred\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Providers\BackAuthServiceProvider;
use Studiosidekicks\Alfred\Core\Commands\Install;
use Studiosidekicks\Alfred\Core\Commands\PublishMigrations;
use Studiosidekicks\Alfred\Core\Commands\SetupPrimaryAccount;
use Studiosidekicks\Alfred\Auth\Front\Facades\FrontAuth;
use Studiosidekicks\Alfred\Auth\Front\Services\FrontAuthService;
use Studiosidekicks\Alfred\Core\Providers\AlfredCoreServiceProvider;
use Studiosidekicks\Alfred\Dashboard\Providers\DashboardServiceProvider;
use Studiosidekicks\Alfred\Log\Providers\LogServiceProvider;

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
        $this->prepareResources();
        $this->registerOtherProviders();

        $this->registerFrontAuth();

        $this->registerCommands();
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
        ], 'alfred-config');

        // Publish migrations
        $migrations = realpath(__DIR__ . '/../../database/migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'alfred-migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/alfred'),
        ], 'alfred-templates');
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
        $this->app->register(AlfredCoreServiceProvider::class);

        $this->app->register(BackAuthServiceProvider::class);

        $this->app->register(DashboardServiceProvider::class);
        $this->app->register(LogServiceProvider::class);
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
            PublishMigrations::class,
            SetupPrimaryAccount::class,
            Install::class,
        ]);
    }
}
