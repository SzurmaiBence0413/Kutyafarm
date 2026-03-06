<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->dropUserIdForeignIfExists();

        if (!$this->hasUserIdForeignTo('users')) {
            Schema::table('dogs', function (Blueprint $table) {
                $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropUserIdForeignIfExists();

        if (!$this->hasUserIdForeignTo('users')) {
            Schema::table('dogs', function (Blueprint $table) {
                $table->foreign('userId')->references('id')->on('users')->onDelete('restrict');
            });
        }
    }

    private function dropUserIdForeignIfExists(): void
    {
        if (!Schema::hasTable('dogs')) {
            return;
        }

        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        $database = DB::connection()->getDatabaseName();

        $foreignKeyName = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', 'dogs')
            ->where('COLUMN_NAME', 'userId')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($foreignKeyName) {
            DB::statement("ALTER TABLE `dogs` DROP FOREIGN KEY `{$foreignKeyName}`");
        }
    }

    private function hasUserIdForeignTo(string $tableName): bool
    {
        if (!Schema::hasTable('dogs')) {
            return false;
        }

        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            return false;
        }

        $database = DB::connection()->getDatabaseName();

        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', 'dogs')
            ->where('COLUMN_NAME', 'userId')
            ->where('REFERENCED_TABLE_NAME', $tableName)
            ->exists();
    }
};
