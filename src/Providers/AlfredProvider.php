<?php

namespace  Studiosidekicks\Alfred\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Providers\BackAuthServiceProvider;
use Studiosidekicks\Alfred\Auth\Front\Facades\FrontAuth;
use Studiosidekicks\Alfred\Auth\Front\Services\FrontAuthService;
use Studiosidekicks\Alfred\Core\Providers\AlfredCoreServiceProvider;
use Studiosidekicks\Alfred\Core\Providers\AlfredCorsServiceProvider;
use Studiosidekicks\Alfred\Dashboard\Providers\DashboardServiceProvider;
use Studiosidekicks\Alfred\FileManager\Providers\FileManagerServiceProvider;
use Studiosidekicks\Alfred\Group\Providers\GroupServiceProvider;
use Studiosidekicks\Alfred\Http\Middleware\AlfredCors;
use Studiosidekicks\Alfred\Log\Providers\LogServiceProvider;
use Studiosidekicks\Alfred\User\Providers\UserServiceProvider;

class AlfredProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Router $router)
    {
        $router->aliasMiddleware('cors', AlfredCors::class);
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->prepareResources();
        $this->registerOtherProviders();

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
        ], 'alfred-config');

        // Publish migrations
        $migrations = realpath(__DIR__ . '/../../database/migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'alfred-migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/alfred'),
        ], 'alfred-templates');

        $this->app->make(EloquentFactory::class)->load(base_path('/../../databases/factories'));
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
        $this->app->register(AlfredCorsServiceProvider::class);

        $this->app->register(BackAuthServiceProvider::class);
        $this->app->register(FileManagerServiceProvider::class);

        $this->app->register(DashboardServiceProvider::class);
        $this->app->register(LogServiceProvider::class);

        $this->app->register(UserServiceProvider::class);
        $this->app->register(GroupServiceProvider::class);
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
}
