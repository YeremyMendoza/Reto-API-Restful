<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\StoreDepartamentoRequest;
use App\Http\Requests\UpdateDepartamentoRequest;

use App\Models\Departamento;
use Exception;

class DepartamentoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/departamentos",
     *     summary="Lista todos los departamentos",
     *     tags={"Departamentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista paginada de departamentos"
     *     )
     * )
     */
    public function index() : JsonResponse
    {
        //
        $departamentos = Departamento::paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $departamentos
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/departamentos",
     *     summary="Crear un nuevo departamento",
     *     tags={"Departamentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre_departamento", "encargado_id"},
     *             @OA\Property(property="nombre_departamento", type="string"),
     *             @OA\Property(property="encargado_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Departamento creado exitosamente"
     *     )
     * )
     */
    public function store(StoreDepartamentoRequest $request) : JsonResponse
    {
        //
        $departamento = Departamento::create($request->validated());

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'data' => $this->serializeDepartamento($departamento)
        ], 201);
    }
        /**
     * @OA\Get(
     *     path="/api/departamentos/{value}",
     *     summary="Buscar departamentos por ID o nombre",
     *     tags={"Departamentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="value",
     *         in="path",
     *         required=true,
     *         description="Valor para buscar en departamento_id o nombre_departamento",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Departamento no encontrado"
     *     )
     * )
     */
    public function show(string $value) : JsonResponse
    {
        //
        $fields = ['departamento_id', 'nombre_departamento'];
        $departamento = Departamento::filtro($fields, $value);

        if($departamento->isEmpty()){
            return response()->json([
                'status' => 'not found',
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
     *     path="/api/departamentos/{id}",
     *     summary="Actualizar un departamento",
     *     tags={"Departamentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre_departamento", "encargado_id"},
     *             @OA\Property(property="nombre_departamento", type="string"),
     *             @OA\Property(property="encargado_id", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento actualizado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Departamento no encontrado"
     *     )
     * )
     */
    public function update(UpdateDepartamentoRequest $request, string $id) : JsonResponse
    {
        //
        $departamento = Departamento::findOrFail($id);

        $departamento->update($request->validated());

        return response()->json([
            'status' => 'success',
            'data' => $this->serializeDepartamento($departamento)
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/departamentos/{id}",
     *     summary="Eliminar un departamento",
     *     tags={"Departamentos"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del departamento a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Departamento eliminado exitosamente"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        //
        $deparamento = Departamento::findOrFail($id);

        $deparamento->delete();

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    private function serializeDepartamento(Departamento $dpto)
    {
        return $dpto->only(['departamento_id', 'nombre_departamento', 'encargado_id', 'subdepartamento_de']);
    }
}
