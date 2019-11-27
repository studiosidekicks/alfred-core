<?php

namespace Studiosidekicks\Alfred\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Core\Entities\AlfredModel;
use Studiosidekicks\Alfred\Core\Observers\AlfredModelObserver;

class AlfredCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        AlfredModel::observe(AlfredModelObserver::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}