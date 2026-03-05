<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
}

