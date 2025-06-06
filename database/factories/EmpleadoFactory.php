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
            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->lastName(),
            'carnet_identidad' => fake()->unique()->numberBetween(1000000, 7000000),
            'fecha_nacimiento' => fake()->date('Y_m_d'),
            'pais' => fake()->country(),
            'departamento' => fake()->state(),
            'ciudad' => fake()->city(),
            'zona' => fake()->streetAddress(),
            'calle' => fake()->streetName(),
            'numero_puerta' => fake()->buildingNumber(),
            'email' => fake()->email(),
            'numero_celular' => (string) fake()->numberBetween(10000000, 99999999),
            'fecha_contratacion' => fake()->date('Y_m_d'),
            'salario' => fake()->numberBetween(2000, 10000)
        ];
    }
}
