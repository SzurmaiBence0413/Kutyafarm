<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class BreedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_wrapped_breeds_data(): void
    {
        DB::table('breeds')->insert([
            ['breed' => 'Golden Retriever', 'created_at' => now(), 'updated_at' => now()],
            ['breed' => 'German Shepherd', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->getJson('/api/breeds');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data',
            ]);
    }

    public function test_show_returns_single_breed(): void
    {
        $breedId = DB::table('breeds')->insertGetId([
            'breed' => 'Beagle',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->getJson("/api/breeds/{$breedId}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $breedId)
            ->assertJsonPath('data.breed', 'Beagle');
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/breeds', [
            'breed' => 'Akita',
        ]);

        $response->assertStatus(401);
    }
}
