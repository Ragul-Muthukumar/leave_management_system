<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_list_returns_users()
    {
        User::factory()->count(5)->create();

        $response = $this->actingAs(User::factory()->create(['role' => 1]))
                         ->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [
                         'data' => [
                             '*' => ['id', 'name', 'email', 'role']
                         ]
                     ]
                 ]);
    }
}

