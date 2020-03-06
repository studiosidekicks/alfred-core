<?php

namespace Studiosidekicks\Alfred\User\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\User\Contracts\MyAccountServiceContract;
use Studiosidekicks\Alfred\User\Services\MyAccountService;

class UserServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
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
        $this->app->bind(MyAccountServiceContract::class, function () {
            return new MyAccountService();
        });
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [];
    }
}