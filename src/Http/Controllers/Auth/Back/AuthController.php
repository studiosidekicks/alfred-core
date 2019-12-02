<?php

namespace Studiosidekicks\Alfred\Http\Controllers\Auth\Back;

use BackAuth;
use Studiosidekicks\Alfred\Auth\Back\Requests\LoginRequest;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;

class AuthController extends ApiResponseController
{
    public function postLogin(LoginRequest $request)
    {
        list($response, $error) = BackAuth::login($request->get('email'), $request->get('password'), $request->filled('remember_me'));
        return $this->response($response, $error);
    }

    public function postLogout()
    {
        list($message, $error) = BackAuth::logout();
        return $this->response($message, $error);
    }
}