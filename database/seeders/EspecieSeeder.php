<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Especie;

class EspecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Especie::create([
                'nombre_cientifico' => fake()->unique()->name(),
                'tiempo_para_adultez' => fake()->numberBetween(10, 50) . ' años',
                'region_origen' => fake()->randomElement(['Cuenca Mediterránea', 'Norte de África', 'Europa del Sur']),
                'clima' => fake()->randomElement(['Templado', 'Seco', 'Semiárido', 'Continental']),
                'enlace_descripcion' => 'https://es.wikipedia.org/wiki/' . fake()->name(),
                'foto_especie' => 'especie_' . $i  . '.jpg',
                'beneficios' => fake()->randomElement([
                    'Fijación de nitrógeno y prevención de erosión',
                    'Sombra y refugio para fauna local',
                    'Producción de frutos silvestres',
                    'Alta resistencia a sequías'
                ]),
            ]);
        }
    }
}
