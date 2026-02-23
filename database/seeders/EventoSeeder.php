<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $usuariosIds = Usuario::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Evento::create([
                'nombre'       => 'Reforestación ' . fake()->unique()->city(),
                'descripcion'=> fake()->unique()->safeEmail(),
                'ubicacion'  => fake()->address(),
                'fecha' => fake()->dateTimeBetween('now', '+6 months'),
                'tipo_terreno'       => fake()->randomElement(['Bosque mediterráneo', 'Ribera', 'Alta montaña', 'Zona incendiada', 'Urbano']),
                'tipo_evento'   => fake()->randomElement(['Plantación masiva', 'Mantenimiento y riego', 'Taller de bombas de semillas', 'Limpieza de entorno']),
                'imagen'     => 'imagen_' . $i . '.jpg',
                'id_usuario'   => fake()->randomElement($usuariosIds),
            ]);
        }
    }
}
