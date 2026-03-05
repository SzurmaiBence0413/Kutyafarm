<?php

namespace Tests\Unit\Database\Constraints;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UniqueConstraintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dogs_chip_number_must_be_unique(): void
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

        $payload = [
            'breedId' => $breedId,
            'dogName' => 'Rex',
            'userId' => null,
            'dateOfBirth' => '2020-01-01',
            'chipNumber' => '123456789012345',
            'gender' => 1,
            'colorId' => $colorId,
            'weight' => 18.5,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('dogs')->insert($payload);

        $this->expectException(QueryException::class);
        DB::table('dogs')->insert($payload);
    }

    public function test_vaccinations_composite_key_is_unique(): void
    {
        $breedId = DB::table('breeds')->insertGetId([
            'breed' => 'Test Breed 2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $colorId = DB::table('colors')->insertGetId([
            'colorName' => 'Black',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dogId = DB::table('dogs')->insertGetId([
            'breedId' => $breedId,
            'dogName' => 'Bella',
            'userId' => null,
            'dateOfBirth' => '2021-02-02',
            'chipNumber' => '999999999999999',
            'gender' => 0,
            'colorId' => $colorId,
            'weight' => 12.3,
            'teeth' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $medicineId = DB::table('medicines')->insertGetId([
            'medicineName' => 'Rabies-Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = [
            'dogId' => $dogId,
            'medicineId' => $medicineId,
            'timeOfVaccination' => '2026-01-01',
            'vaccinationPrice' => 25000,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('vaccinations')->insert($payload);

        $this->expectException(QueryException::class);
        DB::table('vaccinations')->insert($payload);
    }
}

