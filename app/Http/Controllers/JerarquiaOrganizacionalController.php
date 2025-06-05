<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Departamento;
use App\Models\Empleado;

class JerarquiaOrganizacionalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/jerarquia",
     *     summary="Obtener jerarquía de departamentos principales",
     *     tags={"Jerarquía Organizacional"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de departamentos principales con sus subdepartamentos, encargados y subordinados",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Departamento"))
     *     )
     * )
     */
    public function jerarquia(): JsonResponse
    {
        $departamentos = Departamento::with('subdepartamentos.encargado.subordinados')
        ->whereNull('subdepartamento_de') // solo departamentos principales
        ->get();

        return response()->json($departamentos);
    }
    /**
     * @OA\Get(
     *     path="/api/jerarquia/{id}",
     *     summary="Obtener información de un departamento y su jerarquía interna",
     *     tags={"Jerarquía Organizacional"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del departamento",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Información del departamento con subdepartamentos, encargados, subordinados y empleados",
     *         @OA\JsonContent(ref="#/components/schemas/Departamento")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Departamento no encontrado"
     *     )
     * )
     */
    public function supervisor(string $value): JsonResponse
    {
        $departamento = Departamento::with('subdepartamentos.encargado.subordinados')->findOrFail($value);

        $departamento->loadMissing('encargado.subordinados', 'empleados');

        return response()->json($departamento);

    }
}
