<?php

namespace Tests\Feature\Auth\Back;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Studiosidekicks\Alfred\Tests\TestCase;
use Sentinel;

class loginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_correct_details()
    {
        $this->createActivatedUser();

        $response = $this->loginUser('password');

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'You have successfully logged in']);
    }

    public function test_user_can_logout_when_authenticated()
    {
        $this->createActivatedUser();

        $response = $this->loginUser('password');
        $response = $this->json('post', '/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'You have been successfully logout.']);
    }

    public function test_user_cannot_use_login_endpoint_when_authenticated()
    {
        $this->createActivatedUser();

        $response = $this->loginUser('password');
        $response = $this->loginUser('password');

        $response->assertStatus(403)
            ->assertJsonFragment(['message' => 'Access forbidden']);
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        $this->createActivatedUser();

        $response = $this->loginUser('invalid-password');

        $response->assertStatus(400)
            ->assertJsonFragment(['message' => 'Invalid credentials']);

    }

    public function test_user_cannot_login_with_non_existent_email()
    {
        $response = $this->loginUser('password');

        $response->assertStatus(400)
            ->assertJsonFragment(['message' => 'Invalid credentials']);
    }

    public function test_user_cannot_login_with_failure_more_than_five_times_in_a_fifteen_minutes()
    {
        $this->createActivatedUser();

        for ($i = 0; $i <= 5; $i++) {
            $response = $this->loginUser('invalid-password');
        }

        $response->assertStatus(400);
    }

    public function test_signing_log_is_inserted_after_successful_login()
    {
        $user = $this->createActivatedUser();

        $response = $this->loginUser('password');

        $this->assertTrue($user->signings()->where('is_successful', true)->exists());
    }

    public function test_signing_log_is_inserted_after_unsuccessful_login()
    {
        $user = $this->createActivatedUser();

        $response = $this->loginUser('invalid-password');

        $this->assertTrue($user->signings()->where([
            'is_successful' => false,
            'message' => 'Invalid credentials'
        ])->exists());

    }

    private function loginUser(string $password, bool $rememberMe = false)
    {
        return $this->json('post','/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => $password,
            'remember_me' => $rememberMe
        ]);
    }

    private function createActivatedUser()
    {
        $user = factory(BackUser::class)->create([
            'email' => 'test@example.com',
        ]);

        $user->completeActivation();

        return $user;
    }
}