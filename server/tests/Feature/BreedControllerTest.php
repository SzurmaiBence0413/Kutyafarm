<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Breed;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BreedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_breeds()
    {
        Breed::factory()->count(3)->create();

        $response = $this->getJson('/api/breeds');

        $response->assertStatus(200);
    }

    public function test_store_creates_new_breed()
    {
        $data = [
            'name' => 'Golden Retriever',
        ];

        $response = $this->postJson('/api/breeds', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('breeds', [
            'name' => 'Golden Retriever'
        ]);
    }

    public function test_show_returns_single_breed()
    {
        $breed = Breed::factory()->create();

        $response = $this->getJson("/api/breeds/{$breed->id}");

        $response->assertStatus(200);
    }

    public function test_update_modifies_breed()
    {
        $breed = Breed::factory()->create([
            'name' => 'Old Name'
        ]);

        $response = $this->putJson("/api/breeds/{$breed->id}", [
            'name' => 'New Name'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('breeds', [
            'id' => $breed->id,
            'name' => 'New Name'
        ]);
    }

    public function test_destroy_deletes_breed()
    {
        $breed = Breed::factory()->create();

        $response = $this->deleteJson("/api/breeds/{$breed->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('breeds', [
            'id' => $breed->id
        ]);
    }
}
