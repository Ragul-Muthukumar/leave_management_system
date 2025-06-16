<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Leaves;
use Laravel\Sanctum\Sanctum;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate($role = 0)
    {
        $user = User::factory()->create(['role' => $role]);
        Sanctum::actingAs($user);
        return $user;
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => '123456',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token']);
    }

    /** @test */
    public function user_can_login()
    {
        $user = User::factory()->create(['password' => bcrypt('123456')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    /** @test */
    public function user_can_logout()
    {
        $this->authenticate();

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Logged out successfully']);
    }

    /** @test */
    public function user_can_fetch_users()
    {
        $this->authenticate();
        User::factory()->count(5)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonStructure(['success', 'data']);
    }

    /** @test */
    public function user_can_create_leave()
    {
        $this->authenticate();

        $response = $this->postJson('/api/leaves', [
            'start_date' => now()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'reason' => 'Vacation'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Leave created successfully']);
    }

    /** @test */
    public function user_can_get_leaves()
    {
        $this->authenticate();
        Leaves::factory()->count(3)->create();

        $response = $this->getJson('/api/leaves');

        $response->assertStatus(200)
                 ->assertJsonStructure(['leaves']);
    }

    /** @test */
    public function manager_can_approve_leave()
    {
        $this->authenticate(role: 1);
        $leave = Leaves::factory()->create(['status' => 1]);

        $response = $this->patchJson("/api/leaves/{$leave->id}/approve");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Leave approved']);
    }

    /** @test */
    public function manager_can_reject_leave()
    {
        $this->authenticate(role: 1);
        $leave = Leaves::factory()->create(['status' => 2]);

        $response = $this->patchJson("/api/leaves/{$leave->id}/reject");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Leave rejected']);
    }
}
