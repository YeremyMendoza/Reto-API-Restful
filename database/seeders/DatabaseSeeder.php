<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Departamento;
use App\Models\Empleado;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Departamento::factory()
        ->has(
            Departamento::factory()->count(2)->state(function(array $attributes, Departamento $departamento){
                return ["subdepartamento_de" => $departamento->departamento_id];
        }), 'subdepartamentos')->create()->each(function ($departamento) {

            $jefe = Empleado::factory()->create([
                'departamento_id' => $departamento->departamento_id,
            ]);

            $departamento->update([
                'encargado_id' => $jefe->empleado_id
            ]);

            $subordinados = Empleado::factory()->count(2)->create([
                'departamento_id' => $departamento->departamento_id,
                'encargado_id' => $jefe->empleado_id
            ]);
        });
    }
}
