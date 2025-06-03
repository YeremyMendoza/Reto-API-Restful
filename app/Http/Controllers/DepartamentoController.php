<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Departamento;
use App\Http\Requests\StoreDepartamentoRequest;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        //
        $departamentos = Departamento::paginate(20);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $departamentos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartamentoRequest $request) : JsonResponse
    {
        //

        $departamento = Departamento::create([
            'nombre_departamento' => $request->nombre_departamento,
            'encargado_id' => $request->encargado_id,
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 201,
            'data' => $this->serializeDepartamento($departamento)
        ]);
    }

    public function search(Request $request): JsonResponse
    {
        $id     = $request->query('id');
        $nombre = $request->query('nombre');
        $fecha  = $request->query('fecha');

        $query = Departamento::query();

        if ($id) {
            $query->where('departamento_id', $id);
        }

        if ($nombre) {
            $query->where('nombre_departamento', 'like', '%' . $nombre . '%');
        }

        if ($fecha) {
            $query->whereDate('created_at', $fecha);
        }

        $resultados = $query->get(['departamento_id', 'nombre_departamento', 'encargado_id']);

        if ($resultados->isEmpty()) {
            return response()->json([
                'status' => 'not found',
                'code' => 404,
                'message' => 'No se encontraron departamentos con los criterios especificados.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $resultados
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) : JsonResponse
    {
        //
        $departamento = Departamento::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $this->serializeDepartamento($departamento)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepartamentoRequest $request, string $id) : JsonResponse
    {
        //
        $departamento = Departamento::findOrFail($id);

        $departamento->update([
            'nombre_departamento' => $request->nombre_departamento,
            'encargado_id' => $request->encargado_id,
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $this->serializeDepartamento($departamento)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Departamento::destroy($id);

        return response()->json([
            'status' => 'success',
            'code' => 200,
        ]);
    }

    private function serializeDepartamento(Departamento $dpto)
    {
        return $dpto->only(['departamento_id', 'nombre_departamento', 'encargado_id']);
    }
}
