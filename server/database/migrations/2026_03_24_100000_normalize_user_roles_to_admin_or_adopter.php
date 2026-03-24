<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!DB::getSchemaBuilder()->hasTable('users')) {
            return;
        }

        DB::table('users')
            ->whereNotIn('role', [1, 2])
            ->update(['role' => 2]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // no-op
    }
};

