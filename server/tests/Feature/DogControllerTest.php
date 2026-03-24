<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_dogs_wrapped_in_api_response(): void
    {
        $breedId = DB::table('breeds')->insertGetId([
            'breed' => 'Labrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colorId = DB::table('colors')->insertGetId([
            'colorName' => 'Black',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('dogs')->insert([
            'breedId' => $breedId,
            'dogName' => 'Max',
            'userId' => null,
            'dateOfBirth' => '2020-01-01',
            'chipNumber' => '123456789012345',
            'gender' => 1,
            'colorId' => $colorId,
            'weight' => 24.8,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->getJson('/api/dogs');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data',
            ]);
    }

    public function test_show_returns_single_dog(): void
    {
        $breedId = DB::table('breeds')->insertGetId([
            'breed' => 'Husky',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colorId = DB::table('colors')->insertGetId([
            'colorName' => 'White',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dogId = DB::table('dogs')->insertGetId([
            'breedId' => $breedId,
            'dogName' => 'Luna',
            'userId' => null,
            'dateOfBirth' => '2021-06-01',
            'chipNumber' => '555555555555555',
            'gender' => 0,
            'colorId' => $colorId,
            'weight' => 19.2,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->getJson("/api/dogs/{$dogId}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $dogId)
            ->assertJsonPath('data.dogName', 'Luna');
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/dogs', [
            'breedId' => 1,
            'dogName' => 'Test Dog',
        ]);

        $response->assertStatus(401);
    }

    public function test_update_rejects_duplicate_chip_number(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123',
            'role' => User::ROLE_ADMIN,
        ]);

        Sanctum::actingAs($admin, ['dogs:patch']);

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

        $dogAId = DB::table('dogs')->insertGetId([
            'breedId' => $breedId,
            'dogName' => 'Dog A',
            'userId' => null,
            'dateOfBirth' => '2020-01-01',
            'chipNumber' => '111111111111111',
            'gender' => 1,
            'colorId' => $colorId,
            'weight' => 10.0,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dogBId = DB::table('dogs')->insertGetId([
            'breedId' => $breedId,
            'dogName' => 'Dog B',
            'userId' => null,
            'dateOfBirth' => '2021-01-01',
            'chipNumber' => '222222222222222',
            'gender' => 0,
            'colorId' => $colorId,
            'weight' => 12.0,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->patchJson("/api/dogs/{$dogBId}", [
            'chipNumber' => '111111111111111',
        ])->assertStatus(422);

        $this->assertDatabaseHas('dogs', [
            'id' => $dogAId,
            'chipNumber' => '111111111111111',
        ]);

        $this->assertDatabaseHas('dogs', [
            'id' => $dogBId,
            'chipNumber' => '222222222222222',
        ]);
    }
}
