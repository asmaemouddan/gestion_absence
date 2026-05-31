<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EtudiantFactory extends Factory
{
    protected $model = Etudiant::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create([
                'role' => 'etudiant',
            ])->id,

            'classe_id' => Classe::inRandomOrder()->first()?->id,

            'image' => 'etudiants/default.png',
        ];
    }
}