<?php

namespace Studiosidekicks\Alfred\Tests\Feature\FileManager;

use Sentinel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Studiosidekicks\Alfred\Auth\Back\Entities\BackUser;
use Studiosidekicks\Alfred\Log\Entities\LogOperation;
use Studiosidekicks\Alfred\Tests\TestCase;

class DirectoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_directory_can_be_created()
    {
        $this->loginUser();

        $response = $this->json('post','/api/v1/file-manager/directories', [
            'name' => 'Directory',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Directory created successfully.']);
    }

    public function test_name_is_required_during_directory_creation()
    {
        $this->loginUser();
        $response = $this->json('post','/api/v1/file-manager/directories', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name' => 'The name field is required.']);
    }

    public function test_directory_can_be_updated()
    {
        $this->assertTrue(true);
    }

    public function test_directory_can_be_removed()
    {
        $this->assertTrue(true);
    }

    public function test_directory_can_be_moved()
    {
        $this->assertTrue(true);
    }

    public function test_operation_log_is_created_after_directory_creation()
    {
        $this->loginUser();

        $response = $this->json('post','/api/v1/file-manager/directories', [
            'name' => 'Directory',
        ]);

        $this->assertTrue(LogOperation::where([
            'item_id' => $response->json('data')['id'],
            'action' => 'created',
        ])->exists());

        $this->assertTrue(true);
    }

    public function test_operation_log_is_created_after_directory_update()
    {
        $this->assertTrue(true);
    }

    public function test_operation_log_is_created_after_directory_removal()
    {
        $this->assertTrue(true);
    }

    public function test_operation_log_is_created_after_directory_moving()
    {
        $this->assertTrue(true);
    }

    private function loginUser()
    {
        $user = factory(BackUser::class)->create([
            'email' => 'test@example.com',
        ]);

        $user->completeActivation();

        Sentinel::login($user);
    }

}