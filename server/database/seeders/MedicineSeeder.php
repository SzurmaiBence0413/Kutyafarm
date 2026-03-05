<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'medicineName' => 'DHPP',
                'shortName' => 'DHPP',
                'badge' => 'Core',
                'description' => 'Combination vaccine that protects against distemper, hepatitis, parainfluenza, and parvovirus.',
                'recommendedAge' => '6-8 weeks old',
                'frequency' => 'Every 3-4 weeks until 16 weeks',
                'sideEffects' => 'Mild fever, tiredness, soreness at injection site',
                'displayOrder' => 1,
            ],
            [
                'medicineName' => 'Rabies',
                'shortName' => 'Rabies Vaccine',
                'badge' => 'Legal',
                'description' => 'Legally required vaccine that protects against fatal rabies infection.',
                'recommendedAge' => '12-16 weeks old',
                'frequency' => 'First dose at 12-16 weeks, then annual or 3-year booster',
                'sideEffects' => 'Low energy, slight swelling, temporary discomfort',
                'displayOrder' => 2,
            ],
            [
                'medicineName' => 'Bordetella',
                'shortName' => 'Bordetella (Kennel Cough)',
                'badge' => 'Lifestyle',
                'description' => 'Recommended for dogs that attend daycare, grooming, boarding, or social training classes.',
                'recommendedAge' => '8 weeks and older',
                'frequency' => 'Every 6-12 months based on exposure risk',
                'sideEffects' => 'Sneezing, mild cough, short-term lethargy',
                'displayOrder' => 3,
            ],
            [
                'medicineName' => 'Leptospirosis',
                'shortName' => 'Leptospirosis',
                'badge' => 'Risk-Based',
                'description' => 'Protects against bacterial infection that can affect dogs and humans in wet environments.',
                'recommendedAge' => '12 weeks and older',
                'frequency' => 'Two initial doses, then yearly booster',
                'sideEffects' => 'Mild fever, reduced appetite, temporary soreness',
                'displayOrder' => 4,
            ],
            [
                'medicineName' => 'Canine Influenza',
                'shortName' => 'Canine Influenza (Dog Flu)',
                'badge' => 'Lifestyle',
                'description' => 'Protects against canine flu strains for dogs in social environments.',
                'recommendedAge' => '8 weeks and older',
                'frequency' => 'Two-dose series, then annual booster',
                'sideEffects' => 'Sleepiness, injection site swelling, mild fever',
                'displayOrder' => 5,
            ],
            [
                'medicineName' => 'Lyme disease',
                'shortName' => 'Lyme Disease Vaccine',
                'badge' => 'Risk-Based',
                'description' => 'Recommended in tick-prone areas to reduce the risk of Lyme disease.',
                'recommendedAge' => '9 weeks and older',
                'frequency' => 'Two-dose series, then annual booster',
                'sideEffects' => 'Fatigue, tenderness, short-lived fever',
                'displayOrder' => 6,
            ],
            [
                'medicineName' => 'Parvovirus',
                'shortName' => 'Parvovirus',
                'badge' => 'Core',
                'description' => 'Prevents severe intestinal disease especially in puppies.',
                'recommendedAge' => '6-8 weeks old',
                'frequency' => 'Part of puppy core series',
                'sideEffects' => 'Minor tiredness, local tenderness',
                'displayOrder' => 7,
            ],
        ];

        if (Medicine::count() === 0) {
            Medicine::insert($data);
        }
    }
}
