<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->string('shortName', 120)->nullable()->after('medicineName');
            $table->string('badge', 50)->nullable()->after('shortName');
            $table->text('description')->nullable()->after('badge');
            $table->string('recommendedAge', 120)->nullable()->after('description');
            $table->string('frequency', 180)->nullable()->after('recommendedAge');
            $table->string('sideEffects', 180)->nullable()->after('frequency');
            $table->unsignedInteger('displayOrder')->nullable()->after('sideEffects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'shortName',
                'badge',
                'description',
                'recommendedAge',
                'frequency',
                'sideEffects',
                'displayOrder',
            ]);
        });
    }
};
