<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */



    public function run(): void
    {
        Usuario::create([
            'nick' => 'admin',
            'nombre' => 'Administrador',
            'email' => 'admin@reforesta.com',
            'ubicacion' => 'Sede Central',
            'karma' => 1000,
            'avatar' => 'admin.jpg',
            'tipo' => 'admin', 
            'password' => Hash::make('1234'), 
        ]);

        for ($i = 0; $i < 10; $i++) {
            Usuario::create([
                'nick'       => fake()->userName(),
                'nombre'     => fake()->name(),
                'email'      => fake()->unique()->safeEmail(),
                'ubicacion'  => fake()->city() . ', ' . fake()->country(),
                'avatar'     => 'avatar_' . $i . '.jpg',
                'tipo'       => fake()->randomElement(['admin', 'cliente', 'editor']),
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
