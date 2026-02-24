<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Especie;
use App\Models\Evento;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $this->call([
            UsuarioSeeder::class,
            EspecieSeeder::class,
        ]);

        $usuariosIds = Usuario::pluck('id');
        $especiesIds = Especie::pluck('id');

        $this->call(EventoSeeder::class);

        $eventos = Evento::all();
        foreach ($eventos as $evento) {
            $evento->usuarios()->attach(
                $usuariosIds->random(rand(3, 8))->toArray()
            );

            $evento->especies()->attach(
                $especiesIds->random(rand(1, 4))->toArray()
            );
        }
    }
}
