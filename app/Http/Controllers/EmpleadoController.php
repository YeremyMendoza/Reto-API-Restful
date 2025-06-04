<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Validation\Rule;

use App\Models\Empleado;

use App\Http\Requests\StoreEmpleadoRequest;
use App\Http\Requests\UpdateEmpleadoRequest;

class EmpleadoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/empleados",
     *     summary="Obtener listado paginado de empleados",
     *     tags={"Empleados"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de empleados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 description="Datos paginados",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     )
     * )
     */
    public function index() : JsonResponse
    {
        //
        $empleados = Empleado::paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $empleados
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/empleados",
     *     summary="Crear un nuevo empleado",
     *     tags={"Empleados"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=201,
     *         description="Empleado creado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=201),
     *         )
     *     )
     * )
     */
    public function store(StoreEmpleadoRequest $request) : JsonResponse
    {
        //
        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'carnet_identidad' => $request->carnet_identidad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'pais' => $request->pais,
            'departamento' => $request->departamento,
            'ciudad' => $request->ciudad,
            'zona' => $request->zona,
            'calle' => $request->calle,
            'numero_puerta' => $request->numero_puerta,
            'email' => $request->email,
            'departamento_id' => $request->departamento_id,
            'encargado_id' => $request->encargado_id,
            'numero_celular' => $request->numero_celular,
            'fecha_contratacion' => $request->fecha_contratacion,
            'salario' => $request->salario,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'data' => $empleado
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/empleados/{value}",
     *     summary="Buscar empleados filtrando por varios campos",
     *     tags={"Empleados"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="value",
     *         in="path",
     *         description="Valor para filtrar empleados",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resultados encontrados",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=200),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron empleados",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="not found"),
     *             @OA\Property(property="code", type="integer", example=404),
     *             @OA\Property(property="message", type="string", example="No se encontraron departamentos con los criterios especificados.")
     *         )
     *     )
     * )
     */
    public function show(string $value) : JsonResponse
    {
        //
        $fields = [
            'carnet_identidad',
            'departamento',
            'ciudad',
            'numero_celular',
            'estado'
        ];
        $departamento = Empleado::filtro($fields, $value);

        if($departamento->isEmpty()){
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'No se encontraron departamentos con los criterios especificados.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $departamento
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/empleados/{id}",
     *     summary="Actualizar un empleado existente",
     *     tags={"Empleados"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del empleado a actualizar",
     *         required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=200),
     *         )
     *     )
     * )
     */
    public function update(UpdateEmpleadoRequest $request, string $id) : JsonResponse
    {
        //
        $empleado = Empleado::findOrFail($id);
        $empleado->update([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'carnet_identidad' => $request->carnet_identidad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'pais' => $request->pais,
            'departamento' => $request->departamento,
            'ciudad' => $request->ciudad,
            'zona' => $request->zona,
            'calle' => $request->calle,
            'numero_puerta' => $request->numero_puerta,
            'email' => $request->email,
            'departamento_id' => $request->departamento_id,
            'encargado_id' => $request->encargado_id,
            'numero_celular' => $request->numero_celular,
            'fecha_contratacion' => $request->fecha_contratacion,
            'salario' => $request->salario,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $empleado
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/empleados/{id}",
     *     summary="Eliminar un empleado",
     *     tags={"Empleados"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del empleado a eliminar",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="code", type="integer", example=200)
     *         )
     *     )
     * )
     */
    public function destroy(string $id) : JsonResponse
    {
        //
        Empleado::destroy($id);

        return response()->json([
            'status' => 'success',
        ], 200);
    }
}
