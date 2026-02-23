<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Especie>
 */
class EspecieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre_cientifico'   => fake()->unique()->name(),
            'tiempo_para_adultez' => fake()->numberBetween(10, 50) . ' años',
            'region_origen'       => fake()->randomElement(['Cuenca Mediterránea', 'Norte de África', 'Europa del Sur']),
            'clima'               => fake()->randomElement(['Templado', 'Seco', 'Semiárido', 'Continental']),
            'enlace_descripcion'  => 'https://es.wikipedia.org/wiki/' . fake()->name(),
            'foto_especie'        => 'especie_' . fake()->unique()->numberBetween(0, 100) . '.jpg',
            'beneficios'          => fake()->randomElement([
                'Fijación de nitrógeno y prevención de erosión',
                'Sombra y refugio para fauna local',
                'Producción de frutos silvestres',
                'Alta resistencia a sequías'
            ]),
        ];
    }
}
