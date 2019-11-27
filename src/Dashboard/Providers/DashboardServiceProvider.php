<?php

namespace Studiosidekicks\Alfred\Dashboard\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Dashboard\Contracts\DashboardServiceContract;
use Studiosidekicks\Alfred\Dashboard\Services\DashboardService;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DashboardServiceContract::class, DashboardService::class);
    }
}