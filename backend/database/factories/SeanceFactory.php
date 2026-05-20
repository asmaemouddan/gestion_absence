<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Module;
use App\Models\Professeur;
use App\Models\Seance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seance>
 */
class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'classe_id' => Classe::inRandomOrder()->first()?->id,
            'professeur_id' => Professeur::inRandomOrder()->first()?->id,
            'module_id' => Module::inRandomOrder()->first()?->id,
            'date' => fake()->date(),
            'heure_debut' => fake()->randomElement(['08:30', '10:30', '14:00']),
            'heure_fin' => fake()->randomElement(['10:30', '12:30', '16:00']),
        ];
    }
}
