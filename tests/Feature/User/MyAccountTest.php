<?php

namespace Studiosidekicks\Alfred\Tests\Feature\Page;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Studiosidekicks\Alfred\Tests\Feature\LoginUserCase;

class MyAccountTest extends LoginUserCase
{
    use RefreshDatabase;

    public function test_user_can_get_me_data()
    {
        $this->loginUser();

        $response = $this->json('get','/api/v1/me');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'email',
                    'first_name',
                    'last_name',
                    'is_super_admin',
                    'permissions',
                ]
            ]);
    }

    public function test_user_can_get_my_account_data()
    {
        $this->loginUser();

        $response = $this->json('get','/api/v1/my-account');

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'groups'])
            ->assertJsonFragment(['email' => 'test@example.com']);
    }

    public function test_user_can_update_my_account_data()
    {
        $this->loginUser();

        $response = $this->json('put','/api/v1/my-account', [
            'email' => 'test2@example.com',
            'first_name' => 'Test',
            'last_name' => 'Account',
            'role_id' => 1,
        ]);

        $response->assertStatus(200);

        $loggedUser = $this->getLoggedUser();

        $this->assertEquals('test2@example.com', $loggedUser->email);
        $this->assertEquals('Test', $loggedUser->first_name);
        $this->assertEquals('Account', $loggedUser->last_name);
    }

    public function test_user_cannot_update_to_existing_email_address()
    {
        $this->loginUser();

        $this->createSecondUser('test2@example.com');

        $response = $this->json('put','/api/v1/my-account', [
            'email' => 'test2@example.com',
            'first_name' => 'Test',
            'last_name' => 'Account',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.'
            ]);
    }
}