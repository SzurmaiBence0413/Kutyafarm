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

