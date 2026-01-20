<?php

namespace Database\Factories;

use App\Models\Dog;
use App\Models\Medicine;
use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dog = Dog::inRandomOrder()
            ->first();
        $dogId = $dog->id;

        $medicine = Medicine::inRandomOrder()->first();
        $medicineId = $medicine->id;

        return [
            'dogId' => $dogId,
            'medicineId' => $medicineId,
            'timeOfVaccination' => fake()->dateTimeBetween('2010-01-01', 'now'),
            'vaccinationPrice' => fake()->numberBetween(3000, 25000)
        ];
    }
}
