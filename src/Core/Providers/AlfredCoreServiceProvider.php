<?php

namespace Studiosidekicks\Alfred\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Core\Commands\Install;
use Studiosidekicks\Alfred\Core\Commands\PublishMigrations;
use Studiosidekicks\Alfred\Core\Commands\Run;

class AlfredCoreServiceProvider extends ServiceProvider
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
        $this->registerCommands();
    }

    private function registerCommands()
    {
        $this->commands([
            PublishMigrations::class,
            Install::class,
            Run::class,
        ]);
    }
}