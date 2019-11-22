<?php

namespace Studiosidekicks\Alfred\Auth\Front\Services;

use Illuminate\Routing\RouteRegistrar;
use Studiosidekicks\Alfred\Auth\Front\Contracts\UserRepositoryContract;

class FrontAuthService
{
    public function __construct(UserRepositoryContract $userRepositoryContract)
    {

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
            'prefix' => 'auth',
            'namespace' => 'Studiosidekicks\Alfred\Http\Controllers\Auth\Front',
        ];

        $options = array_merge($defaultOptions, $options);

        Route::group($options, function ($router) use ($callback) {
            $callback(new RouteRegistrar($router));
        });
    }
}