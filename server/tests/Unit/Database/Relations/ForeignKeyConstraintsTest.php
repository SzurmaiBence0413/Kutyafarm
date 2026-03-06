<?php

namespace Tests\Unit\Database\Relations;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ForeignKeyConstraintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_dogs_foreign_keys_are_defined(): void
    {
        $foreignKeys = $this->getForeignKeysForTable('dogs');

        $this->assertSame('breeds.id', $foreignKeys['breedId'] ?? null);
        $this->assertSame('users.id', $foreignKeys['userId'] ?? null);
        $this->assertSame('colors.id', $foreignKeys['colorId'] ?? null);
    }

    public function test_photos_foreign_key_is_defined(): void
    {
        $foreignKeys = $this->getForeignKeysForTable('photos');
        $this->assertSame('dogs.id', $foreignKeys['dogId'] ?? null);
    }

    public function test_vaccinations_foreign_keys_are_defined(): void
    {
        $foreignKeys = $this->getForeignKeysForTable('vaccinations');

        $this->assertSame('dogs.id', $foreignKeys['dogId'] ?? null);
        $this->assertSame('medicines.id', $foreignKeys['medicineId'] ?? null);
    }

    private function getForeignKeysForTable(string $table): array
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            $rows = DB::select("PRAGMA foreign_key_list('{$table}')");
            $map = [];
            foreach ($rows as $row) {
                $map[$row->from] = "{$row->table}.{$row->to}";
            }
            return $map;
        }

        $database = DB::connection()->getDatabaseName();
        $rows = DB::select(
            "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
             FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = ?
               AND TABLE_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$database, $table]
        );

        $map = [];
        foreach ($rows as $row) {
            $map[$row->COLUMN_NAME] = "{$row->REFERENCED_TABLE_NAME}.{$row->REFERENCED_COLUMN_NAME}";
        }

        return $map;
    }
}
