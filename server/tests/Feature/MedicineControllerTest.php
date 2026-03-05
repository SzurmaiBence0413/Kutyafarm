<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MedicineControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_medicines_in_api_wrapper(): void
    {
        DB::table('medicines')->insert([
            'medicineName' => 'Rabies',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->getJson('/api/medicines');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data',
            ]);
    }

    public function test_show_returns_single_medicine(): void
    {
        $medicineId = DB::table('medicines')->insertGetId([
            'medicineName' => 'DHPP',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->getJson("/api/medicines/{$medicineId}");

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', $medicineId)
            ->assertJsonPath('data.medicineName', 'DHPP');
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/medicines', [
            'medicineName' => 'Canine Influenza',
        ]);

        $response->assertStatus(401);
    }
}

