<?php

namespace  Studiosidekicks\Alfred\Providers;

use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Facades\BackAuth;
use Studiosidekicks\Alfred\Auth\Back\Repositories\RoleRepository;
use Studiosidekicks\Alfred\Auth\Back\Repositories\UserRepository;
use Studiosidekicks\Alfred\Auth\Back\Services\BackAuthService;

class AlfredProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->setOverrides();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->prepareResources();
        $this->registerBackAuth();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Publish config
        $config = realpath(__DIR__ . '/../../config/config.php');
        $this->mergeConfigFrom($config, 'studiosidekicks.alfred');

        $this->publishes([
            $config => config_path('studiosidekicks.alfred.php'),
        ], 'config');

        // Publish migrations
        $migrations = realpath(__DIR__ . '/../../database/migrations');

        $this->publishes([
            $migrations => $this->app->databasePath().'/migrations',
        ], 'migrations');
    }

    /**
     * Registers the users.
     *
     * @return void
     */
    private function registerBackUsers()
    {
        $this->app->singleton('studiosidekicks.back_auth.users', function ($app) {
            $config = $app['config']->get('studiosidekicks.base.auth.back');

            return new UserRepository(
                $app['sentinel.hasher'],
                $app['events'],
                $config['model']
            );
        });
    }

    /**
     * Registers the roles.
     *
     * @return void
     */
    private function registerBackRoles()
    {
        $this->app->singleton('studiosidekicks.back_auth.roles', function ($app) {
            $config = $app['config']->get('studiosidekicks.base.auth.back');

            return new RoleRepository($config['role_model']);
        });
    }

    /**
     * Registers sentinel.
     *
     * @return void
     */
    protected function registerBackAuth()
    {
        $this->registerBackUsers();
        $this->registerBackRoles();

        $this->app->singleton('studiosidekicks.back_auth', function ($app) {
            return new BackAuthService(
                $app['studiosidekicks.back_auth.users'],
                $app['studiosidekicks.back_auth.roles']
            );
        });

        $this->app->alias('BackAuth', BackAuth::class);
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'studiosidekicks.back_auth',
            'studiosidekicks.back_auth.users',
            'studiosidekicks.back_auth.roles',
        ];
    }

    /**
     * Performs the necessary overrides.
     *
     * @return void
     */
    protected function setOverrides()
    {
        $config = $this->app['config']->get('studiosidekicks.base');

        if ($config['auth']['back']['is_enabled']) {
            //Auth for back (app/cms) users
            $backUserModel = $config['auth']['back']['model'];

            $roles = $config['auth']['back']['role_model'];

            if (class_exists($backUserModel)) {

                if (method_exists($backUserModel, 'setRolesModel')) {
                    forward_static_call_array([$backUserModel, 'setRolesModel'], [$roles]);
                }
            }

            if (class_exists($roles) && method_exists($roles, 'setUsersModel')) {
                forward_static_call_array([$roles, 'setUsersModel'], [$backUserModel]);
            }
        }


        if ($config['auth']['front']['is_enabled']) {
            //Standard auth for front users
            $frontUserModel = $config['auth']['front']['model'];
        }

    }
}
