<?php

namespace Studiosidekicks\Alfred\Http\Controllers\Auth\Back;

use Studiosidekicks\Alfred\Auth\Back\Requests\ResetPasswordRequest;
use Studiosidekicks\Alfred\Auth\Back\Requests\SendPasswordReminderRequest;
use Studiosidekicks\Alfred\Http\Controllers\ApiResponseController;
use BackAuth;

class ResetPasswordController extends ApiResponseController
{
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