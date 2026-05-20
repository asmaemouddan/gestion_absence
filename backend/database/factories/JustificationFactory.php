<?php

namespace Database\Factories;

use App\Models\Justification;
use App\Models\Presence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Justification>
 */
class JustificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'presence_id' => Presence::where('status', 'absent')->inRandomOrder()->first()?->id,
        'motif' => fake()->randomElement([
            'Maladie',
            'Rendez-vous médical',
            'Problème familial',
        ]),
        'fichier' => null,
        'status' => fake()->randomElement(['en_attente', 'acceptee', 'refusee']),

        ];
    }
}
