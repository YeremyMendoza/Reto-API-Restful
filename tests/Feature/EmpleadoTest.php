<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Empleado;
use App\Models\Departamento;

use Illuminate\Support\Str;

use Tymon\JWTAuth\Facades\JWTAuth;

uses(RefreshDatabase::class);


beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'example123*',
    ]);

    $this->departamento = Departamento::factory()->create();

    $this->empleado = Empleado::factory()->create([
        'departamento_id' => $this->departamento->departamento_id
    ]);
});

test('puede visualizar datos de todos los empleados', function(){

    $headers = headers($this->user);

    $response = $this->withHeaders($headers)->getJson('api/empleados');

    $response->assertOk();
});

test('puede registrar un nuevo empleado con datos correctos', function(){

    $headers = headers($this->user);
    $response = $this->withHeaders($headers)->postJson("api/empleados", datosEmpleado($this->departamento));

    $empleadoId = $response->json('data.empleado_id');

    $this->assertDatabaseHas('empleados', [
        'empleado_id' => $empleadoId
    ]);

    $response->assertCreated();
});

test('puede actualizar un empleado existente con datos correctos', function(){

    $id = $this->empleado->empleado_id;

    $headers = headers($this->user);

    $response = $this->withHeaders($headers)->putJson("api/empleados/{$id}", datosEmpleado($this->departamento, $this->empleado));

    $nombreEmpleado = $response->json('data.nombre');

    $this->assertDatabaseHas('empleados', [
        'departamento_id' => $id,
        'nombre' => $nombreEmpleado
    ]);

    $response->assertOk();

});

test('no puede actualizar un empleado no existente', function(){

    $headers = headers($this->user);

    $response = $this->withHeaders($headers)->putJson("api/empleados/-1", datosEmpleado($this->departamento, $this->empleado));

    $response->assertNotFound()->assertJsonPath('status', 'error');
});

test('no puede eliminar un empleado no existente', function(){

    $headers = headers($this->user);

    $response = $this->withHeaders($headers)->deleteJson("api/empleados/-1");

    $response->assertNotFound()->assertJsonPath('status', 'error');
});

test('puede eliminar un empleado existente', function(){

    $headers = headers($this->user);

    $id = $this->empleado->empleado_id;

    $response = $this->withHeaders($headers)->deleteJson("api/empleados/{$id}");

    $this->assertDatabaseMissing('empleados', [
        'empleado_id' => $id,
    ]);

    $response->assertOk()->assertJsonPath('status', 'success');

});

function headers(User $user): Array
{
    $token = JWTAuth::fromUser($user);
    return ['Authorization' => "Bearer $token"];
}

function datosEmpleado(Departamento $departamento, Empleado $empleado = null): array
{
    return [
        "nombre" => Str::random(10),
        "apellido_paterno" => Str::random(10),
        "apellido_materno" => Str::random(10),
        "carnet_identidad" => "7846515",
        "fecha_nacimiento" => "2000-05-20",
        "pais" => Str::random(10),
        "departamento" => "Santa Cruz",
        "ciudad" => Str::random(10),
        "zona" => Str::random(10),
        "calle" => Str::random(10),
        "numero_puerta" => "15",
        "email" => $empleado ? $empleado->email : Str::random(5)."@gmail.com",
        "numero_celular" => $empleado ? $empleado->numero_celular : "79845684",
        "fecha_contratacion" => "2025-06-05",
        "salario" => "2000.00",
        "departamento_id" => $departamento->departamento_id,
        "estado" => false
    ];
}
