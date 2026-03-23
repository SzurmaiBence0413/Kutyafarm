<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FavouriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_favourites_endpoints_require_authentication(): void
    {
        $this->getJson('/api/favourites')->assertStatus(401);
        $this->postJson('/api/favourites', ['dogId' => 1])->assertStatus(401);
        $this->deleteJson('/api/favourites/1')->assertStatus(401);
    }

    public function test_logged_in_user_can_add_list_and_remove_favourites(): void
    {
        $user = User::create([
            'name' => 'Adopter',
            'email' => 'adopter@example.com',
            'password' => '123',
            'role' => User::ROLE_ADOPTER,
        ]);

        Sanctum::actingAs($user, ['favourites:get', 'favourites:post', 'favourites:delete']);

        $dogId = $this->createDog();

        $this->postJson('/api/favourites', ['dogId' => $dogId])
            ->assertStatus(200)
            ->assertJsonPath('data.dogId', $dogId);

        $this->assertDatabaseHas('favourites', [
            'userId' => $user->id,
            'dogId' => $dogId,
        ]);

        $this->getJson('/api/favourites')
            ->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.dogId', $dogId);

        $this->deleteJson("/api/favourites/{$dogId}")
            ->assertStatus(200)
            ->assertJsonPath('data.dogId', $dogId);

        $this->assertDatabaseMissing('favourites', [
            'userId' => $user->id,
            'dogId' => $dogId,
        ]);
    }

    private function createDog(): int
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
            'userId' => null,
            'dateOfBirth' => '2022-01-01',
            'chipNumber' => '321321321321321',
            'gender' => 1,
            'colorId' => $colorId,
            'weight' => 15.5,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
