<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module_professeur', function (Blueprint $table) {
            $table->id();
             $table->foreignId('module_id')
              ->constrained('modules')
              ->cascadeOnDelete();

        $table->foreignId('professeur_id')
              ->constrained('professeurs')
              ->cascadeOnDelete();

        $table->timestamps();

        $table->unique(['module_id', 'professeur_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_professeur');
    }
};
