<?php

namespace Studiosidekicks\Alfred\Tests\Feature\Group;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_user_can_create_a_group()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_update_group()
    {
        $this->assertTrue(true);
    }

    public function test_user_can_destroy_group()
    {
        $this->assertTrue(true);
    }
}