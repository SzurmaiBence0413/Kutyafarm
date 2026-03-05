<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_admin_cannot_change_own_role_via_api(): void
    {
        $admin = User::create([
            'name' => 'Admin2',
            'email' => 'admin2@example.com',
            'password' => '123',
            'role' => 1,
        ]);

        $loginResponse = $this->postJson('/api/users/login', [
            'email' => $admin->email,
            'password' => '123',
        ]);

        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('data.token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->patchJson("/api/users/{$admin->id}", [
            'name' => 'Modositott Admin',
            'role' => '2',
        ]);

        $response->assertStatus(403);
        $this->assertEquals(1, $admin->fresh()->role);
    }
}
