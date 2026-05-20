<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Professeur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Professeur::factory()->count(3)->create();

        Professeur::all()->each(function ($professeur) {
            $modules = Module::inRandomOrder()->take(2)->pluck('id');
            $professeur->modules()->attach($modules);
        });
    }
}
