<?php

namespace Tests\Unit;

// use App\Models\Breed;
// use App\Models\Dog;
// use Illuminate\Container\Attributes\DB;
// use Illuminate\Foundation\Testing\DatabaseTransactions;
// use Illuminate\Support\Facades\Schema;
// use PHPUnit\Framework\TestCase;

use App\Models\Breed;
use App\Models\Dog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use PHPUnit\Framework\Attributes\DataProvider;

class DataBaseTest extends TestCase
{
    use DatabaseTransactions;

    public function test_database_exists()
    {
        $databaseNameConn = DB::connection()->getDatabaseName();
        $databaseNameEnv = env('DB_DATABASE');
        $this->assertEquals($databaseNameConn, $databaseNameEnv, "Az adatbázisunk nem az, amivel dolgozni akarunk");

        //Megvannak-e a tábláink

        echo PHP_EOL . "Adatbázis -> DB_DATABASE={$databaseNameEnv} | adatbázis: {$databaseNameConn}";
    }


    public static function tablesProvider(): array
    {
        return [
            'breeds table' => ['breeds'],
            'colors table' => ['colors'],
            'medicines table' => ['medicines'],
            'dogs table' => ['dogs'],
            'vaccinations table' => ['vaccinations'],
            'photos table' => ['photos'],
            'users table' => ['users'],
        ];
    }

    #[DataProvider('tablesProvider')]
    public function test_tables_exists($table)
    {
        $this->assertTrue(Schema::hasTable($table), "'$table' tábla nem létezik");
    }


    public static function dogsColumnsProvider(): array
    {
        return [
            ['id'],
            ['breedId'],
            ['dogName'],
            ['userId'],
            ['dateOfBirth'],
            ['chipNumber'],
            ['gender'],
            ['colorId'],
            ['weight'],
            ['teeth'],
        ];
    }
    #[DataProvider('dogsColumnsProvider')]
    public function test_dogs_table_has_columns(string $column): void
    {

        $this->assertTrue(
            Schema::hasColumn('dogs', $column),
            "A dogs táblából hiányzik a(z) {$column} oszlop"
        );
    }

    public static function dogsColumnTypesProvider(): array
    {
        return [
            ['id', 'integer'],
            ['breedId', 'integer'],
            ['dogName', 'string'],
            ['userId', 'integer'],
            ['dateOfBirth', 'date'],
            ['chipNumber', 'string'],
            ['gender', 'boolean'],
            ['colorId', 'integer'],
            ['weight', 'double'],
            ['teeth', 'boolean'],
            ['created_at', 'timestamp'],
            ['updated_at', 'timestamp'],
        ];
    }



    #[DataProvider('dogsColumnTypesProvider')]
    public function test_dogs_table_column_types(string $column, string $type): void
    {
        $this->assertEquals(
            $type,
            Schema::getColumnType('dogs', $column),
            "A dogs.{$column} típusa nem {$type}"
        );
    }


    public function xtest_dogss_breeds_relationships()
    {

        //A dogs tábla kapcsolatai
        $tableName = "dogs";
        $foreignKeyName = "schoolclassId";
        $databaseName = env('DB_DATABASE');
        $contstraint_name = "PRIMARY";

        $query = "
            SELECT
                TABLE_NAME,
                COLUMN_NAME,
                CONSTRAINT_NAME,
                REFERENCED_TABLE_NAME,
                REFERENCED_COLUMN_NAME
            FROM
                information_schema.KEY_COLUMN_USAGE
            WHERE
                TABLE_NAME = ? and COLUMN_NAME = ? and CONSTRAINT_SCHEMA = ? and CONSTRAINT_NAME <> ?";

        $rows = DB::select($query, [$tableName, $foreignKeyName, $databaseName, $contstraint_name]);
        // dd($rows);
        //Idegen kulcs neve: osztalyId
        $this->assertEquals('dogs', $rows[0]->COLUMN_NAME);
        //Referencia tábla neve: osztalies
        $this->assertEquals('dogs', $rows[0]->REFERENCED_TABLE_NAME);
        //Referencia oszlop neve: id
        $this->assertEquals('id', $rows[0]->REFERENCED_COLUMN_NAME);


        //Készítünk egy osztályt
        $dataBreed =
            [
                'breed' => ''
            ];
        $breed = Breed::factory()->create($dataBreed);

        //Az új osztállyal készítek egy kutyát
        $dataDog =
            [

                'breedId' => $breed->id,
                'dogName' => 'Rudi',
                'userId' => '1',
                'dateOfBirth' => '2020-01-04',
                'chipNumber' => '123123123123123123',
                'gender' => true,
                'colorId' => '1',
                'weight' => '15',
                'teeth' => true,
            ];
        $dog = Dog::factory()->create($dataDog);

        //visszakeressük a diákot
        $dog =
            DB::table('students')
            ->where('id',  $dog->id)
            ->first();

        //A megtalált kutya breedId-je megegyezik a új breed id-jével
        $this->assertEquals($breed->id, $dog->schoolclassId);
        // dd($diak);

    }
}
