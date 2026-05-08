# Tesztek dokumentálása - DolgShelter Projekt

Ez a dokumentáció a szoftverünk backend részének atesztelési folyamatait mutatja be. A tesztelés során alkalmaztunk Feature és Unit teszteket is.

## Unit tesztek
Az átláthatóság, karbantarthatóság, valamint a gyorsabb hibakeresés végett az unit teszteket különböző osztályokra bontottuk.

### Constrains

Ezek segítettek abban, hogy ne kerüljön ellentmondásos adat az adatbázisba 



***Például:***
EZ e részlet ellenőrzi, hogy az adatbázis megakadályozza-e ugyanannak az oltásnak a többszöri rögzítését ugyanannál a kutyánál ugyanabban az időpontban.

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

### Relations
Ez a teszt vizsgálja a táblák közötti megfelelő kapcsolatokat

***Például:***
Ellenőrzi, hogy a dogs tábla kulcsai létre lettek-e hozva és megfelelő helyre mutatnak-e.

    public function test_dogs_foreign_keys_are_defined(): void
    {
        $foreignKeys = $this->getForeignKeysForTable('dogs');

        $this->assertSame('breeds.id', $foreignKeys['breedId'] ?? null);
        $this->assertSame('users.id', $foreignKeys['userId'] ?? null);
        $this->assertSame('colors.id', $foreignKeys['colorId'] ?? null);
    }

### Schema
Ez megvizsgálja, hogy létetznek - e a táblák és azok szükséges oszlopai.

***Például:***

    <?php

    namespace Tests\Unit\Database\Schema;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Support\Facades\Schema;
    use PHPUnit\Framework\Attributes\DataProvider;
    use Tests\TestCase;

    class TablesAndColumnsTest extends TestCase
    {
        use RefreshDatabase;

    public static function tablesProvider(): array
    {
        return [
            ['users'],
            ['breeds'],
            ['colors'],
            ['medicines'],
            ['dogs'],
            ['photos'],
            ['vaccinations'],
        ];
    }

    #[DataProvider('tablesProvider')]
    public function test_core_tables_exist(string $table): void
    {
        $this->assertTrue(Schema::hasTable($table));
    }

    public function test_dogs_table_has_required_columns(): void
    {
        $requiredColumns = [
            'id',
            'breedId',
            'dogName',
            'userId',
            'dateOfBirth',
            'chipNumber',
            'gender',
            'colorId',
            'weight',
            'teeth',
            'created_at',
            'updated_at',
        ];

        foreach ($requiredColumns as $column) {
            $this->assertTrue(Schema::hasColumn('dogs', $column));
        }
    }
}


## Feature tesztek
Tesztelik a rendszer funkcióit, végpontokat.

***Például:***
Teszteli, hogy a fajták listázása működik-e.
  
     public function test_index_returns_wrapped_breeds_data(): void
    {
        DB::table('breeds')->insert([
            ['breed' => 'Golden Retriever', 'created_at' => now(), 'updated_at' => now()],
            ['breed' => 'German Shepherd', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->getJson('/api/breeds');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data',
            ]);
    }


## Tesztek futtatása: 
***Összes teszt futtatása:***
`php artisan test`

***Egy adott teszt futatása:***
`php artisan test --filter DogControllerTest`


## Tesztek eredménye
| Test Class | Test Name | Status | Time |
|---|---|---|---|
| Tests\Unit\Database\Constraints\UniqueConstraintsTest | dogs chip number must be unique | PASS | 2.04s |
| Tests\Unit\Database\Constraints\UniqueConstraintsTest | vaccinations composite key is unique | PASS | 0.03s |
| Tests\Unit\Database\Constraints\UniqueConstraintsTest | favourites composite key is unique | PASS | 0.05s |
| Tests\Unit\Database\Relations\ForeignKeyConstraintsTest | dogs foreign keys are defined | PASS | 0.05s |
| Tests\Unit\Database\Relations\ForeignKeyConstraintsTest | photos foreign key is defined | PASS | 0.03s |
| Tests\Unit\Database\Relations\ForeignKeyConstraintsTest | vaccinations foreign keys are defined | PASS | 0.05s |
| Tests\Unit\Database\Relations\ForeignKeyConstraintsTest | favourites foreign keys are defined | PASS | 0.05s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #0 | PASS | 0.06s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #1 | PASS | 0.05s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #2 | PASS | 0.05s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #3 | PASS | 0.02s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #4 | PASS | 0.02s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #5 | PASS | 0.04s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | core tables exist with data set #6 | PASS | 0.15s |
| Tests\Unit\Database\Schema\TablesAndColumnsTest | dogs table has required columns | PASS | 0.15s |
| Tests\Unit\ExampleTest | that true is true | PASS | 0.01s |
| Tests\Feature\AdoptionControllerTest | adoptions endpoints require authentication | PASS | 0.08s |
| Tests\Feature\AdoptionControllerTest | adopter can create adoption request | PASS | 0.83s |
| Tests\Feature\AdoptionControllerTest | admin can list adoption requests | PASS | 0.07s |
| Tests\Feature\AdoptionControllerTest | adopter can list only their own adoption requests | PASS | 0.06s |
| Tests\Feature\BreedControllerTest | index returns wrapped breeds data | PASS | 0.09s |
| Tests\Feature\BreedControllerTest | show returns single breed | PASS | 0.03s |
| Tests\Feature\BreedControllerTest | store requires authentication | PASS | 0.02s |
| Tests\Feature\DogControllerTest | index returns dogs wrapped in api response | PASS | 0.04s |
| Tests\Feature\DogControllerTest | show returns single dog | PASS | 0.05s |
| Tests\Feature\DogControllerTest | store requires authentication | PASS | 0.06s |
| Tests\Feature\DogControllerTest | update rejects duplicate chip number | PASS | 0.26s |
| Tests\Feature\ExampleTest | the application returns a successful response | PASS | 2.32s |
| Tests\Feature\FavouriteControllerTest | favourites endpoints require authentication | PASS | 0.05s |
| Tests\Feature\FavouriteControllerTest | logged in user can add list and remove favourites | PASS | 0.04s |
| Tests\Feature\MedicineControllerTest | index returns medicines in api wrapper | PASS | 0.03s |
| Tests\Feature\MedicineControllerTest | show returns single medicine | PASS | 0.05s |
| Tests\Feature\MedicineControllerTest | store requires authentication | PASS | 0.04s |
| Tests\Feature\PingTest | api ping endpoint returns api text | PASS | 0.07s |
| Tests\Feature\UserTest | create user and cannot delete without auth | PASS | 0.09s |
| Tests\Feature\UserTest | login can access protected endpoint then logout | PASS | 0.26s |
| Tests\Feature\UserTest | login accepts legacy plain text password and rehashes it | PASS | 0.03s |
| Tests\Feature\UserUpdateTest | admin cannot change own role via api | PASS | 0.32s |

| Metric | Value |
|---|---|
| Total Tests | 38 |
| Assertions | 95 |
| Passed | 38 |
| Failed | 0 |
| Duration | 7.97s |