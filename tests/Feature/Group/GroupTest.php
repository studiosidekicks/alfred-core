<?php

namespace Studiosidekicks\Alfred\Tests\Feature\Group;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Studiosidekicks\Alfred\Auth\Back\Entities\Role;
use Studiosidekicks\Alfred\Tests\Feature\LoginUserCase;

class GroupTest extends LoginUserCase
{
    use RefreshDatabase;

    public function test_user_can_get_groups_list()
    {
        $this->loginUser();

        $response = $this->json('get','/api/v1/groups');

        $response->assertStatus(200)
            ->assertJsonStructure(['list']);
    }

    public function test_group_required_fields()
    {
        $this->loginUser();
        $response = $this->json('post','/api/v1/groups');

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.'
            ]);
    }


    public function test_user_can_create_a_group()
    {
        $this->loginUser();
        $response = $this->json('post','/api/v1/groups', [
            'name' => 'Test'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Group has been created successfully.'
            ])
            ->assertJsonStructure(['data']);
    }

    public function test_user_can_update_group()
    {
        $this->loginUser();

        $role = Role::create(['name' => 'Test']);

        $response = $this->json('put','/api/v1/groups/' . $role->id, [
            'name' => 'Test Update'
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'message' => 'Group updated successfully.'
            ]);

        $updatedRole = Role::find($role->id);
        $this->assertEquals('Test Update', $updatedRole->name);
    }

    public function test_user_can_destroy_group()
    {
        $this->loginUser();
        $role = Role::create(['name' => 'Test']);

        $response = $this->json('delete','/api/v1/groups/' . $role->id);

        $response->assertStatus(200)
            ->assertJsonFragment(['message' => 'Group has been removed.']);
    }

    public function test_group_with_users_cannot_be_removed()
    {
        $this->loginUser();

        $response = $this->json('delete','/api/v1/groups/1');

        $response->assertStatus(400)
            ->assertJsonFragment(['message' => 'Group cannot have assigned users if you want to remove it.']);
    }
}