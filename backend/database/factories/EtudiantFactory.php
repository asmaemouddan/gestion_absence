<?php

namespace Database\Factories;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class EtudiantFactory extends Factory
{
    protected $model = Etudiant::class;

    public function definition(): array
    {
         $images = File::files(storage_path('app/public/etudiants'));
         $randomImage = collect($images)->random();
        return [
            'user_id' => User::factory()->create([
                'role' => 'etudiant',
            ])->id,

            'classe_id' => Classe::inRandomOrder()->first()?->id,

            'image' => 'etudiants/' . $randomImage->getfilename(),
        ];
    }
}
