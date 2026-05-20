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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
             $table->foreignId('etudiant_id')
              ->constrained('etudiants')
              ->cascadeOnDelete();

        $table->foreignId('seance_id')
              ->constrained('seances')
              ->cascadeOnDelete();

        $table->enum('status', ['present', 'absent', 'retard', 'justifie'])
              ->default('absent');

        $table->time('heure_scan')->nullable();

        $table->timestamps();

        $table->unique(['etudiant_id', 'seance_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
