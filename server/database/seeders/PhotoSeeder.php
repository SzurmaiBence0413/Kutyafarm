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
        Photo::factory()->count(Dog::count())->create();
        // $response = Http::withoutVerifying()->get('https://dog.ceo/api/breed/dane/images/random');
        // $imgUrl = $response->json()['message'];
        // dd($imgUrl);
        // die;


    }
}
