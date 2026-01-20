<?php

namespace Database\Seeders;

use App\Models\Color;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path(path: 'csv\colors.csv');
        $data = [];
        if (file_exists($filePath)) {
            if (($handle = fopen($filePath, 'r')) !== false) {
                // 1. Beolvassuk a fejléceket (ha vannak)
                $header = fgetcsv($handle, 0, ';');

                // 2. Soronként beolvassuk az adatokat (0 azt jelenti, hogy nincs korlát a beolvasott sorra)
                while (($cols = fgetcsv($handle, 0, ',')) !== false) {
                    if (count($header) === count($cols)) {
                        // Asszociatív tömb létrehozása (jobb olvashatóság!)
                        $data[] = array_combine($header, $cols);
                    }
                }
                // 3. Zárjuk a fájlt (itt kötelező!)
                fclose($handle);
            }
        }

        if (Color::count() === 0) {
            Color::factory()->createMany($data);
        }
    }
}
