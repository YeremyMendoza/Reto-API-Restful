<?php
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Empleado;
use App\Models\Departamento;

use Illuminate\Support\Str;

use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);


beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'example123*',
    ]);

    $this->departamento = Departamento::factory()->create();
});

test('puede visualizar datos de todos los departamentos', function(){

    $headers = headersDepartamento($this->user);

    $response = $this->withHeaders($headers)->getJson('api/departamentos');

    $response->assertJson(fn (AssertableJson $json) =>
        $json
            ->where('status', 'success')
            ->has('data.data') 
            ->has('data.data.0.departamento_id')
            ->has('data.current_page')
    );

    $response->assertOk();
});

test('puede visualizar la jerarquia de todos los departamentos tipo arbol', function(){

    $this->seed();

    $headers = headersDepartamento($this->user);

    $response = $this->withHeaders($headers)->getJson("api/jerarquia");

    $response->assertOk();

    $response->assertJson(fn (AssertableJson $json) =>
        $json->each(fn (AssertableJson $departamento) =>
            $departamento
                ->has('subdepartamentos')
                ->has('departamento_id')
                ->has('nombre_departamento')
                ->whereType('subdepartamentos', 'array')
                ->etc()
                ->when(fn ($departamento) => !empty($departamento->toArray()['subdepartamentos']), fn ($departamento) =>
                    $departamento->has('subdepartamentos', fn (AssertableJson $subdepartamentos) =>
                        $subdepartamentos->each(fn (AssertableJson $sub) =>
                            $sub
                                ->has('encargado')
                                ->whereType('encargado', 'array')
                                ->etc()
                        )
                    )
                )
        )
    );
});

test('puede visualizar la jerarquia de un departamento mostrando departamento, encargado, empleados', function(){

    $headers = headersDepartamento($this->user);

    $this->assertDatabaseHas('departamentos', [
        'departamento_id' => 1
    ]);

    $response = $this->withHeaders($headers)->getJson("api/jerarquia/1");

    $response->assertJson(fn (AssertableJson $json) =>
        $json->hasAll(['departamento_id', 'nombre_departamento', 'empleados', 'encargado'])->etc()
    );

    $response->assertOk();
});

test('puede registrar un nuevo departamento', function(){

    $headers = headersDepartamento($this->user);

    $response = $this->withHeaders($headers)->postJson("api/departamentos", datosDepartamento());

    $departamentoId = $response->json('data.departamento_id');

    $this->assertDatabaseHas('departamentos', [
        'departamento_id' => $departamentoId
    ]);

    $response->assertCreated();
});

test('puede actualizar un departamento existente con datos correctos', function(){

    $headers = headersDepartamento($this->user);

    $id = $this->departamento->departamento_id;

    $response = $this->withHeaders($headers)->putJson("api/departamentos/{$id}", datosDepartamento());

    $nombreDepartamento = $response->json('data.nombre_departamento');

    $this->assertDatabaseHas('departamentos', [
        'departamento_id' => $id,
        'nombre_departamento' => $nombreDepartamento
    ]);

    $response->assertOk();
});

test('no puede actualizar un departamento no existente', function(){

    $headers = headersDepartamento($this->user);

    $response = $this->withHeaders($headers)->putJson('api/departamentos/-1', datosDepartamento());

    $response->assertNotFound()->assertJsonPath('status', 'error');
});

test('no puede eliminar un departamento no existente', function(){

    $headers = headersDepartamento($this->user);

    $response = $this->withHeaders($headers)->deleteJson("api/departamentos/-1");

    $response->assertNotFound()->assertJsonPath('status', 'error');
});

test('puede eliminar un departamento existente', function(){

    $headers = headersDepartamento($this->user);

    $id = $this->departamento->departamento_id;

    $response = $this->withHeaders($headers)->deleteJson("api/departamentos/{$id}");

    $this->assertDatabaseMissing('departamentos', [
        'departamento_id' => $id,
    ]);

    $response->assertOk()->assertJsonPath('status', 'success');
});

function headersDepartamento(User $user): Array
{
    $token = JWTAuth::fromUser($user);
    return ['Authorization' => "Bearer $token"];
}

function datosDepartamento(Departamento $departamento = null): array
{
    return [
        'nombre_departamento' => Str::random(10), 
        'encargado_id' => null,
        'subdepartamento_de' => null
    ];
}