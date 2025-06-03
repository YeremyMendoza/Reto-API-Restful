<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $empleados = Empleado::all();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'data' => $empleados
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => ['required', 'string', 'min:5', 'max:10'], 
            'apellido_paterno' => ['required', 'string', 'min:5', 'max:10'], 
            'apellido_materno' => ['required', 'string', 'min:5', 'max:10'], 
            'email' => ['string', 'email', 'max:20', 'unique:empleados,email'], 
            'numero_celular' => ['required', 'string', 'min:8', 'max:15'],
            'fecha_contratacion' => ['required', Rule::date()->format('Y-m-d')], 
            'salario' => ['required', 'decimal:2,4'],
            'imagen_principal' => ['required', 'nullable', File::image()->min('1kb')->max('5mb')],
            'estado' => ['boolean', 'sometimes', Rule::in(['1', '0'])]
        ]);

        $empleado = 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
