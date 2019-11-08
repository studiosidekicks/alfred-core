<?php

namespace Studiosidekicks\Alfred\Auth\Back\Services;

use Studiosidekicks\Alfred\Auth\Back\Contracts\RoleRepositoryContract;
use Studiosidekicks\Alfred\Auth\Back\Contracts\UserRepositoryContract;
use Illuminate\Support\Facades\Route;

class BackAuthService
{
    private $usersRepository;
    private $rolesRepository;

    public function __construct(
        UserRepositoryContract $usersRepository,
        RoleRepositoryContract $rolesRepository
    ) {
        $this->usersRepository = $usersRepository;
        $this->rolesRepository = $rolesRepository;
    }


    /**
     * Binds the Passport routes into the controller.
     *
     * @param  callable|null  $callback
     * @param  array  $options
     * @return void
     */
    public static function routes($callback = null, array $options = [])
    {
        $callback = $callback ?: function ($router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'backend/auth',
            'namespace' => 'Studiosidekicks\Alfred\Auth\Back\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}