<?php

namespace Database\Seeders;

use App\Models\Etudiant;
use App\Models\Presence;
use App\Models\Seance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PresenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seances = Seance::all();
        $etudiants = Etudiant::all();

        foreach ($seances as $seance) {
            foreach ($etudiants->random(min(5, $etudiants->count())) as $etudiant) {
                Presence::create([
                    'etudiant_id' => $etudiant->id,
                    'seance_id' => $seance->id,
                    'status' => fake()->randomElement(['present', 'absent', 'retard']),
                    'heure_scan' => fake()->optional()->time('H:i:s'),
                ]);
            }
        }
    }
}
