<?php

namespace Database\Seeders;
use App\Models\Dog;
use App\Models\Photo;
use Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Dog::all()->each(function ($dog) {
        Photo::factory()->create([
            'dogId' => $dog->id,
        ]);
    });

    }
}
