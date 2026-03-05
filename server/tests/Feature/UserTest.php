<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    private function login(string $email, string $password)
    {
        return $this->postJson('/api/users/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    private function logout(string $token)
    {
        return $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->postJson('/api/users/logout');
    }

    public function test_create_user_and_cannot_delete_without_auth(): void
    {
        $data = [
            'name' => 'Vasarlo 3',
            'email' => 'vasarlo3@example.com',
            'password' => '123',
        ];

        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);

        $id = $response->json('data.id');
        $this->deleteJson("/api/users/{$id}")->assertStatus(401);
    }

    public function test_login_can_access_protected_endpoint_then_logout(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin_test@example.com',
            'password' => '123',
            'role' => 1,
        ]);

        $loginResponse = $this->login($user->email, '123');
        $loginResponse->assertStatus(200);

        $token = $loginResponse->json('data.token');
        $this->assertNotNull($token);

        $this->withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->getJson('/api/users')->assertStatus(200);

        $this->logout($token)->assertStatus(200);
    }
}
