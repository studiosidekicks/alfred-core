<?php

namespace Studiosidekicks\Alfred\Auth\Back\Services;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forLogin();
        $this->forRegistration();
        $this->forPasswordReset();
        $this->forActivation();
    }

    private function forLogin()
    {
        $this->router->group(['middleware' => ['guest:api']], function ($router) {
            $router->post('login', 'LoginController@postLogin')->name('auth.back.login');
        });

        $this->router->group(['middleware' => ['jwt']], function ($router) {
            $router->post('logout', 'LoginController@logout')->name('auth.back.logout');
        });
    }

    private function forRegistration()
    {
        $this->router->group(['middleware' => ['guest:api']], function ($router) {
            $router->post('register', 'RegisterController@postRegister')->name('auth.back.register');
        });
    }

    private function forPasswordReset()
    {
    }

    private function forActivation()
    {

    }
}