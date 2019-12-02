<?php

namespace Studiosidekicks\Alfred\Tests\Feature\Auth\Back;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Studiosidekicks\Alfred\Auth\Back\Events\ResetPasswordStarted;
use Studiosidekicks\Alfred\Auth\Back\Mail\PasswordReset;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_cannot_access_reset_endpoint()
    {
        $this->createActivatedUser();
        $this->loginUser('password');

        $response = $this->json('post', 'api/v1/auth/password/reminder');
        $response->assertForbidden();
    }

    public function test_send_reminder_email_is_required()
    {
        $this->createActivatedUser();

        $response = $this->postJson('api/v1/auth/password/reminder');

        $response->assertStatus(422)
            ->assertJsonValidationErrors('email');
    }

    public function test_reminder_email_has_been_sent()
    {
        Event::fake();
//        Mail::fake();

        $user = $this->createActivatedUser();

        $response = $this->json('post', 'api/v1/auth/password/reminder', [
            'email' => 'monika@biggerpicture.agency'
        ]);

        Event::assertDispatched(ResetPasswordStarted::class);

//        Mail::assertSent(PasswordReset::class);

        $response->assertStatus(200);
    }

//    public function test_reset_link_is_valid()
//    {
//        $user = $this->createActivatedUser();
//
//
//    }

//    public function test_new_password_needs_to_be_confirmed()
//    {
//
//    }
//
//    public function test_user_can_set_new_password()
//    {
//
//    }
//

//
//    public function test_link_cannot_be_used_again()
//    {
//
//    }

    private function loginUser(string $password, bool $rememberMe = false)
    {
        return $this->json('post','/api/v1/auth/login', [
            'email' => 'monika@biggerpicture.agency',
            'password' => $password,
            'remember_me' => $rememberMe
        ]);
    }

    private function createActivatedUser()
    {
        $user = factory(BackUser::class)->create([
            'email' => 'monika@biggerpicture.agency',
        ]);

        $user->completeActivation();

        return $user;
    }

}