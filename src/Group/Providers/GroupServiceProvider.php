<?php

namespace Studiosidekicks\Alfred\Group\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Repositories\RoleRepository;
use Studiosidekicks\Alfred\Group\Contracts\GroupServiceContract;
use Studiosidekicks\Alfred\Group\Services\GroupService;

class GroupServiceProvider extends ServiceProvider
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
        $this->app->bind(GroupServiceContract::class, function () {
            $config = config('studiosidekicks.alfred.auth.back');

            return new GroupService(new RoleRepository($config['role_model']));
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