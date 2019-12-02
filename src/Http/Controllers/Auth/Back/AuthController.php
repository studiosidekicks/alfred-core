<?php

namespace Studiosidekicks\Alfred\Http\Controllers\Auth\Back;

use BackAuth;
use Studiosidekicks\Alfred\Auth\Back\Requests\LoginRequest;
use Studiosidekicks\Alfred\Auth\Back\Requests\ResetPasswordRequest;
use Studiosidekicks\Alfred\Auth\Back\Requests\SendPasswordReminderRequest;
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

    public function sendPasswordReminder(SendPasswordReminderRequest $request)
    {
        list($message, $error) = BackAuth::sendPasswordReminder($request->get('email'));
        return $this->response($message, $error);
    }

    public function verifyPasswordResetData($code, $userId)
    {
        list($message, $error) = BackAuth::verifyPasswordResetData($code, $userId);
        return $this->response($message, $error);
    }

    public function resetPassword(ResetPasswordRequest $request, $code, $userId)
    {
        list($message, $error) = BackAuth::resetPassword($code, $userId, $request->get('password'));
        return $this->response($message, $error);
    }
}