<?php

namespace Studiosidekicks\Alfred\Tests\Feature;

use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Studiosidekicks\Alfred\Tests\TestCase;
use Sentinel;

class LoginUserCase extends TestCase
{
    protected function loginUser()
    {
        $user = factory(BackUser::class)->create([
            'email' => 'test@example.com',
        ]);

        $user->completeActivation();

        Sentinel::login($user);
    }

    protected function getLoggedUser()
    {
        return Sentinel::getUser();
    }

    protected function createSecondUser($email)
    {
        factory(BackUser::class)->create([
            'email' => $email,
        ]);
    }
}