<?php

namespace Studiosidekicks\Alfred\Auth\Back\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Studiosidekicks\Alfred\Auth\Back\Facades\BackAuth;
use Studiosidekicks\Alfred\Auth\Back\Facades\RoleAccessor;
use Studiosidekicks\Alfred\Auth\Back\Middleware\BackAuthMiddleware;
use Studiosidekicks\Alfred\Auth\Back\Middleware\BackNoAuthMiddleware;
use Studiosidekicks\Alfred\Auth\Back\Observers\BackUserObserver;
use Studiosidekicks\Alfred\Auth\Back\Repositories\RoleRepository;
use Studiosidekicks\Alfred\Auth\Back\Repositories\UserRepository;
use Studiosidekicks\Alfred\Auth\Back\Services\BackAuthService;
use Studiosidekicks\Alfred\Auth\Back\Services\RoleService;

class BackAuthServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->setOverrides();
        BackUser::observe(BackUserObserver::class);

        $router->aliasMiddleware('back-auth', BackAuthMiddleware::class);
        $router->aliasMiddleware('back-no-auth', BackNoAuthMiddleware::class);

        $this->loadViewsFrom(__DIR__ . '/../../../../resources/views', 'alfred');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackAuth();

        $this->app->register(BackAuthEventServiceProvider::class);
    }


    /**
     * Registers sentinel.
     *
     * @return void
     */
    protected function registerBackAuth()
    {
        $config = config('studiosidekicks.alfred');

        if (!empty($config['auth']['back']['is_enabled'])) {

            $this->registerBackUsers();
            $this->registerBackRoles();

            $this->app->singleton('studiosidekicks.alfred.back_auth', function ($app) {
                return new BackAuthService(
                    $app['studiosidekicks.alfred.back_auth.users'],
                    $app['studiosidekicks.alfred.back_auth.roles']
                );
            });

            $this->app->singleton('studiosidekicks.alfred.role_accessor', function ($app) {
                return new RoleService(
                    $app['studiosidekicks.alfred.back_auth.roles']
                );
            });

            $this->app->alias('BackAuth', BackAuth::class);
            $this->app->alias('RoleAccessor', RoleAccessor::class);
        }
    }

    /**
     * Registers the users.
     *
     * @return void
     */
    private function registerBackUsers()
    {
        $this->app->singleton('studiosidekicks.alfred.back_auth.users', function ($app) {
            $config = config('studiosidekicks.alfred.auth.back');

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
        $this->app->singleton('studiosidekicks.alfred.back_auth.roles', function ($app) {
            $config = config('studiosidekicks.alfred.auth.back');

            return new RoleRepository($config['role_model']);
        });
    }

    /**
     * Performs the necessary overrides.
     *
     * @return void
     */
    protected function setOverrides()
    {
        $config = config('studiosidekicks.alfred');

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

    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            'studiosidekicks.alfred.back_auth',
            'studiosidekicks.alfred.back_auth.users',
            'studiosidekicks.alfred.back_auth.roles',
        ];
    }
}
