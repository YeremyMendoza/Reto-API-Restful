<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => fake()->firstName(),
            'apellido_paterno' => fake()->lastname(),
            'apellido_materno' => fake()->lastname(),
            'carnet_identidad' => fake()->unique()->numberBetween(1000000, 7000000),
            'fecha_nacimiento' => fake()->date('Y_m_d'),
            'pais' => fake()->country(),
            'departamento' => fake()->state(),
            'ciudad' => fake()->city(),
            'zona' => fake()->streetAddress(),
            'calle' => fake()->streetName(),
            'numero_puerta' => fake()->buildingNumber(),
            'email' => fake()->email(),
            'numero_celular' => fake()->phoneNumber(),
            'fecha_contratacion' => fake()->date('Y_m_d'),
            'salario' => fake()->numberBetween(2000, 10000)
        ];
    }
}
