<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    User::factory()->create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'telephone' => '0600000000',
        'role' => 'admin',
        'password' => bcrypt('password'),
    ]);

    User::factory()->create([
        'name' => 'Ahmed Professeur',
        'email' => 'prof@gmail.com',
        'telephone' => '0611111111',
        'role' => 'professeur',
        'password' => bcrypt('password'),
    ]);

    User::factory(5)->create();

    $this->call([
        ClasseSeeder::class,
        ModuleSeeder::class,
        ProfesseurSeeder::class,
        EtudiantSeeder::class,
        SeanceSeeder::class,
        PresenceSeeder::class,
        JustificationSeeder::class,
    ]);
}
}
