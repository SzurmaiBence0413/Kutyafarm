<?php

namespace Database\Factories;

use App\Models\Breed;
use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    public function definition(): array
    {
        $user = User::where('role', 2)
            ->inRandomOrder()
            ->first();
        $userId = $user->id;

        $breeds = Breed::inRandomOrder()->first();
        $breedId = $breeds->id;


        $color = Color::inRandomOrder()->first();
        $colorId = $color->id;
        $maleDogNames = [
            'Bodri',
            'Buksi',
            'Rex',
            'Max',
            'Bruno',
            'Rocky',
            'Zeusz',
            'Thor',
            'Cézár',
            'Duke',
            'Charlie',
            'Jack',
            'Lucky',
            'Sam',
            'Toby',
            'Oscar',
            'Milo',
            'Leo',
            'Ben',
            'Hunter',
            'Shadow',
            'Spike',
            'Bandit',
            'Hector',
            'Apollo',
            'Diesel',
            'Kaiser',
            'Nero',
            'Balto',
            'Simba',
            'Kano',
            'Fickó',
            'Kormi',
            'Morcos',
            'Vacak',
            'Betyár',
            'Csibész',
            'Kapitány',
            'Villám',
            'Zorro',
            'Balu',
            'Medve',
            'Pajti',
            'Samu',
            'Dönci',
            'Füge',
            'Manó',
            'Zénó',
            'Bors',
            'Csoki'
        ];
        $femaleDogNames = [
            'Luna',
            'Bella',
            'Daisy',
            'Molly',
            'Lucy',
            'Lola',
            'Ruby',
            'Rosie',
            'Nala',
            'Mia',
            'Zoey',
            'Chloe',
            'Sophie',
            'Ellie',
            'Poppy',
            'Willow',
            'Coco',
            'Pepper',
            'Hazel',
            'Ivy',
            'Fifi',
            'Maci',
            'Panka',
            'Saci',
            'Bogyó',
            'Pötyi',
            'Maszat',
            'Folti',
            'Zizi',
            'Maya',
            'Kira',
            'Zara',
            'Lexi',
            'Skye',
            'Nova',
            'Freya',
            'Arya',
            'Vera',
            'Lili',
            'Mézi',
            'Habcsók',
            'Zsömle',
            'Csipke',
            'Szofi',
            'Bambi',
            'Pille',
            'Tara',
            'Cili',
            'Gyöngy',
            'Mancs'
        ];

        $gender = fake()->numberBetween(0, 1);
        if ($gender == 0) {
            //szuka
            $dogName = fake()->randomElement($femaleDogNames);

        } else {
            $dogName = fake()->randomElement($maleDogNames);
        }
        return [
            'breedId' => $breedId,
            'dogName' => $dogName,
            'userId' => $userId,
            'dateOfBirth' => fake()->dateTimeBetween('2010-01-01', 'now'),
            'chipNumber' => fake()->unique()->numerify(str_repeat('#', 15)),
            'gender' => $gender,
            'colorId' => $colorId,
            'weight' => fake()->randomFloat(2, 1, 60),
            'teeth' => fake()->numberBetween(0, 1)
        ];
    }
}
