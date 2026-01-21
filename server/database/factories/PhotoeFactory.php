<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Photoe;
use Http;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photoe>
 */
class PhotoeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $breeds = [
            'labrador',
            'germanshepherd',
            'goldenretriever',
            'frenchbulldog',
            'bulldogenglish',
            'poodle',
            'beagle',
            'rottweiler',
            'terrieryorkshire',
            'boxer',
            'doberman',
            'husky',
            'shihtzu',
            'collieborder',
            'australianshepherd',
            'spanielcocker',
            'dachshund',
            'pug',
            'stbernard',
            'akita',
            'malamute',
            'chihuahua',
            'weimaraner',
            'dane',
            'pomeranian',
            'samoyed',
            'shiba',
            'maltese',
            'basset',
            'dalmatian',
        ];

        $dog = Dog::inRandomOrder()->first();
        $dogId = $dog->id;
        $response = Http::withoutVerifying()->get('https://dog.ceo/api/breeds/image/random');
        $imgUrl = $response->json()['message'];
        return [

            'dogId' => $dogId,
            'imgUrl' => $imgUrl
        ];
    }
}
