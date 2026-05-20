<?php

namespace Database\Factories;

use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Presence>
 */
class PresenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etudiant_id' => Etudiant::inRandomOrder()->first()?->id,
            'seance_id' => Seance::inRandomOrder()->first()?->id,
            'status' => fake()->randomElement(['present', 'absent', 'retard']),
            'heure_scan' => fake()->optional()->time('H:i:s'),
        ];
    }
}
