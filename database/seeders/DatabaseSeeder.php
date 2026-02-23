<?php

namespace Database\Seeders;

use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Especie;
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
        \App\Models\Usuario::factory(10)->create();
        \App\Models\Especie::factory(10)->create();
        \App\Models\Evento::factory(10)->create();
    }
}
