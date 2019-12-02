<?php

namespace Studiosidekicks\Alfred\Log\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Log\Facades\Error;
use Studiosidekicks\Alfred\Log\Facades\Operation;
use Studiosidekicks\Alfred\Log\Facades\Signing;
use Studiosidekicks\Alfred\Log\Repositories\SigningsRepository;
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
        $this->app->singleton('alfred-operations', function () {
            return new OperationsService();
        });

        $this->app->singleton('alfred-signings', function () {
            return new SigningsService(new SigningsRepository());
        });

        $this->app->singleton('alfred-errors', function () {
            return new ErrorsService();
        });

        $this->app->alias('Operation', Operation::class);
        $this->app->alias('Error', Error::class);
        $this->app->alias('Signing', Signing::class);
    }
}