<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'user_id' => User::factory()->create([
            'role' => 'etudiant',
        ])->id,

        'classe_id' => Classe::inRandomOrder()->first()?->id,

        'image' => 'visages/default.png',
    ];
    }
}
