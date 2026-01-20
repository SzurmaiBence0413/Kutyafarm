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
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('breedId')->constrained('breeds')->onDelete('restrict');
            $table->string('dogName');
            $table->foreignId('userId')->nullable()->constrained('breeds')->onDelete('restrict');
            $table->date('dateOfBirth');
            $table->string('chipNumber', 15)->unique();
            $table->boolean('gender');
            $table->foreignId('colorId')->constrained('colors')->onDelete('restrict');
            $table->double('weight');
            $table->boolean('teeth');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dogs');
    }
};
