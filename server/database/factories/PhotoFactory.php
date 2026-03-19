<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Photo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http as FacadesHttp;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photoe>
 */
class PhotoFactory extends Factory
{
    private const FALLBACK_IMAGE = 'https://images.unsplash.com/photo-1517849845537-4d257902454a?auto=format&fit=crop&w=900&q=80';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dog = Dog::inRandomOrder()->first();
        $dogId = $dog->id;
        $imgUrl = self::FALLBACK_IMAGE;

        try {
            $response = FacadesHttp::withoutVerifying()
                ->timeout(10)
                ->get('https://dog.ceo/api/breeds/image/random');

            $payload = $response->json();
            if ($response->successful() && is_array($payload) && !empty($payload['message'])) {
                $imgUrl = $payload['message'];
            }
        } catch (\Throwable $exception) {
            $imgUrl = self::FALLBACK_IMAGE;
        }

        return [
            'dogId' => $dogId,
            'imgUrl' => $imgUrl
        ];
    }
}
