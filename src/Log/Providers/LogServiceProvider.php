<?php

namespace Studiosidekicks\Alfred\Log\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Log\Contracts\ErrorsServiceContract;
use Studiosidekicks\Alfred\Log\Contracts\OperationsServiceContract;
use Studiosidekicks\Alfred\Log\Contracts\SigningsServiceContract;
use Studiosidekicks\Alfred\Log\Services\ErrorsService;
use Studiosidekicks\Alfred\Log\Services\OperationsService;
use Studiosidekicks\Alfred\Log\Services\SigningsService;

class LogServiceProvider extends ServiceProvider
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
        $this->app->bind(OperationsServiceContract::class, OperationsService::class);

        $this->app->bind(ErrorsServiceContract::class, ErrorsService::class);

        $this->app->bind(SigningsServiceContract::class, SigningsService::class);

    }
}