<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'       => 'Reforestación ' . fake()->unique()->city(),
            'descripcion'  => fake()->unique()->safeEmail(), 
            'ubicacion'    => fake()->address(),
            'fecha'        => fake()->dateTimeBetween('now', '+6 months'),
            'tipo_terreno' => fake()->randomElement(['Bosque mediterráneo', 'Ribera', 'Alta montaña', 'Zona incendiada', 'Urbano']),
            'tipo_evento'  => fake()->randomElement(['Plantación masiva', 'Mantenimiento y riego', 'Taller de bombas de semillas', 'Limpieza de entorno']),
            'imagen'       => 'imagen_' . fake()->unique()->numberBetween(0, 100) . '.jpg',
            'id_usuario'   => Usuario::inRandomOrder()->first() ?? Usuario::factory(),
        ];
    }
}
