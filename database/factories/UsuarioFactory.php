<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nick'      => fake()->unique()->userName(),
            'nombre'    => fake()->name(),
            'email'     => fake()->unique()->safeEmail(),
            'ubicacion' => fake()->city() . ', ' . fake()->country(),
            'avatar'    => 'avatar_' . fake()->numberBetween(0, 50) . '.jpg',
            'tipo'      => fake()->randomElement(['admin', 'cliente', 'editor']),
            'password'  => Hash::make('password'),
        ];
    }
}
