<?php

namespace Studiosidekicks\Alfred\Core\Providers;

use Asm89\Stack\CorsService;
use Fruitcake\Cors\CorsServiceProvider;
use Studiosidekicks\Alfred\Http\Middleware\AlfredCors;

class AlfredCorsServiceProvider extends CorsServiceProvider
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

        $this->app->singleton(CorsService::class, function ($app) {
            $config = config('studiosidekicks.cors');

            // Convert case to supported options
            $options = [
                'supportsCredentials' => $config['supports_credentials'],
                'allowedOrigins' => $config['allowed_origins'],
                'allowedOriginsPatterns' => $config['allowed_origins_patterns'],
                'allowedHeaders' => $config['allowed_headers'],
                'allowedMethods' => $config['allowed_methods'],
                'exposedHeaders' => $config['exposed_headers'],
                'maxAge' => $config['max_age'],
            ];

            // Transform wildcard pattern
            foreach ($options['allowedOrigins'] as $origin) {
                if (strpos($origin, '*') !== false) {
                    $options['allowedOriginsPatterns'][] = $this->convertWildcardToPattern($origin);
                }
            }

            return new CorsService($options);
        });
    }

    public function boot()
    {
        parent::boot();
        app()->make('router')->pushMiddlewareToGroup('web', AlfredCors::class);
    }

}