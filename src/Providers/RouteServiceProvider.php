<?php

namespace Studiosidekicks\Alfred\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Studiosidekicks\Alfred\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiV1Routes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "api" routes (cms) for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiV1Routes()
    {
        Route::prefix('api/v1')
            ->middleware(['web'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../../routes/api-v1.php');


        Route::get('cms', 'CmsController@index')->middleware('web');
    }

    /**
     * Define the "web" routes
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web'])
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../../routes/web.php');
    }
}