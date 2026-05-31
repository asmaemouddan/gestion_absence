<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    public function run(): void
    {
        $seances = Seance::all();
        $etudiants = Etudiant::all();

        if ($seances->isEmpty() || $etudiants->isEmpty()) {
            return;
        }

        foreach ($seances as $seance) {
            $selectedEtudiants = $etudiants->random(min(5, $etudiants->count()));

            foreach ($selectedEtudiants as $etudiant) {
                Presence::updateOrCreate(
                    [
                        'etudiant_id' => $etudiant->id,
                        'seance_id' => $seance->id,
                    ],
                    [
                        'status' => fake()->randomElement(['present', 'absent', 'retard']),
                        'heure_scan' => fake()->optional()->time('H:i:s'),
                    ]
                );
            }
        }
    }
}