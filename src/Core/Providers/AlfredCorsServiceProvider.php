<?php

namespace Studiosidekicks\Alfred\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Http\Middleware\AlfredCors;

class AlfredCorsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Publish cors config
        $corsConfig = realpath(__DIR__ . '/../../../config/cors.php');
        $this->mergeConfigFrom($corsConfig, 'studiosidekicks.cors');

        $this->publishes([
            $corsConfig => config_path('studiosidekicks.cors.php'),
        ], 'alfred-cors-config');
    }

    public function boot()
    {
        app()->make('router')->pushMiddlewareToGroup('web', AlfredCors::class);
    }

}