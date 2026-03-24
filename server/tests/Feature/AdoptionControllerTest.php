<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdoptionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_adoptions_endpoints_require_authentication(): void
    {
        $this->postJson('/api/adoptions', [])->assertStatus(401);
        $this->getJson('/api/adoptions')->assertStatus(401);
    }

    public function test_adopter_can_create_adoption_request(): void
    {
        $adopter = User::create([
            'name' => 'Adopter',
            'email' => 'adopter@example.com',
            'password' => '123',
            'role' => User::ROLE_ADOPTER,
        ]);

        Sanctum::actingAs($adopter, ['adoptions:post']);

        $dogId = $this->createDog();

        $payload = [
            'dogId' => $dogId,
            'fullName' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+361234567',
            'city' => 'Budapest',
            'message' => 'I would love to adopt.',
        ];

        $this->postJson('/api/adoptions', $payload)
            ->assertStatus(200)
            ->assertJsonPath('data.dogId', $dogId)
            ->assertJsonPath('data.userId', $adopter->id)
            ->assertJsonPath('data.status', 'pending');

        $this->assertDatabaseHas('adoption_requests', [
            'dogId' => $dogId,
            'userId' => $adopter->id,
            'email' => 'jane@example.com',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_list_adoption_requests(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123',
            'role' => User::ROLE_ADMIN,
        ]);

        $adopter = User::create([
            'name' => 'Adopter',
            'email' => 'adopter@example.com',
            'password' => '123',
            'role' => User::ROLE_ADOPTER,
        ]);

        $dogId = $this->createDog($admin->id);

        DB::table('adoption_requests')->insert([
            'dogId' => $dogId,
            'userId' => $adopter->id,
            'fullName' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+361234567',
            'city' => 'Budapest',
            'message' => null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Sanctum::actingAs($admin, ['adoptions:get']);

        $this->getJson('/api/adoptions')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.dogId', $dogId);
    }

    public function test_adopter_can_list_only_their_own_adoption_requests(): void
    {
        $adopter = User::create([
            'name' => 'Adopter',
            'email' => 'adopter@example.com',
            'password' => '123',
            'role' => User::ROLE_ADOPTER,
        ]);

        $otherAdopter = User::create([
            'name' => 'Other Adopter',
            'email' => 'other-adopter@example.com',
            'password' => '123',
            'role' => User::ROLE_ADOPTER,
        ]);

        $dogId = $this->createDog(null);

        DB::table('adoption_requests')->insert([
            'dogId' => $dogId,
            'userId' => $adopter->id,
            'fullName' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '+361234567',
            'city' => 'Budapest',
            'message' => null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('adoption_requests')->insert([
            'dogId' => $dogId,
            'userId' => $otherAdopter->id,
            'fullName' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+369999999',
            'city' => 'Szeged',
            'message' => null,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Sanctum::actingAs($adopter, ['adoptions:get']);

        $this->getJson('/api/adoptions')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.userId', $adopter->id);
    }

    private function createDog(?int $userId = null): int
    {
        $breedId = DB::table('breeds')->insertGetId([
            'breed' => 'Test Breed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colorId = DB::table('colors')->insertGetId([
            'colorName' => 'Brown',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return DB::table('dogs')->insertGetId([
            'breedId' => $breedId,
            'dogName' => 'Lucky',
            'userId' => $userId,
            'dateOfBirth' => '2022-01-01',
            'chipNumber' => '999999999999999',
            'gender' => 1,
            'colorId' => $colorId,
            'weight' => 15.5,
            'teeth' => 1,
            'description' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
