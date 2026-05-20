<?php

namespace Database\Factories;

use App\Models\Professeur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Professeur>
 */
class ProfesseurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(['role' => 'professeur'])->id,
            'specialite' => fake()->randomElement([
            'Développement Web',
            'Base de données',
            'Réseaux',
            'Intelligence Artificielle',
        ]),
        ];
    }
}
