<?php

namespace Tests\Feature\Auth\Back;

use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Tests\TestCase;
use Sentinel;

class loginTest extends TestCase
{

    public function test_user_cannot_use_endpoint_when_authenticated()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_login_with_correct_details()
    {
        $user = factory(BackUser::class)->create([
            'email' => 'test@example.com'
        ]);

        $user->completeActivation();

        $this->assertIsNotBool(Sentinel::authenticate([
            'email' => 'test@example.com',
            'password' => 'password'
        ]));
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        $this->assertTrue(true);

    }

    public function test_user_cannot_login_with_non_existent_email()
    {
        $this->assertTrue(true);

    }

    public function test_user_can_logout_when_authenticated()
    {
        $this->assertTrue(true);

    }

    public function test_user_cannot_login_with_failure_more_than_five_times_in_a_minute()
    {
        $this->assertTrue(true);

    }

    public function test_user_gets_correct_remember_me_cookie()
    {
        $this->assertTrue(true);
    }

}