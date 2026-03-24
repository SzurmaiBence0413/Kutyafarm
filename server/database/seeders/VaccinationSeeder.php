<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use Illuminate\Database\Seeder;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //100 véletlen termék generálása
        $dogIds = \App\Models\Dog::query()->pluck('id')->all();
        $medicineIds = \App\Models\Medicine::query()->pluck('id')->all();

        if (!$dogIds || !$medicineIds) {
            return;
        }

        $targetCount = 400;
        $created = 0;
        $attempts = 0;
        $maxAttempts = $targetCount * 50;
        $used = [];

        while ($created < $targetCount && $attempts < $maxAttempts) {
            $attempts++;

            $dogId = $dogIds[array_rand($dogIds)];
            $medicineId = $medicineIds[array_rand($medicineIds)];
            $date = fake()->dateTimeBetween('2010-01-01', 'now')->format('Y-m-d');
            $key = "{$dogId}-{$medicineId}-{$date}";

            if (isset($used[$key])) {
                continue;
            }

            $used[$key] = true;

            $createdRow = Vaccination::query()->firstOrCreate(
                [
                    'dogId' => $dogId,
                    'medicineId' => $medicineId,
                    'timeOfVaccination' => $date,
                ],
                [
                    'vaccinationPrice' => fake()->numberBetween(3000, 25000),
                ]
            );

            if ($createdRow->wasRecentlyCreated) {
                $created++;
            }
        }
    }
}
