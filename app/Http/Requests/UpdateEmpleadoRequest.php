<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateEmpleadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //

            'nombre' => ['required', 'string', 'min:5', 'max:50'],
            'apellido_materno' => ['required', 'string', 'min:5', 'max:50'],
            'apellido_paterno' => ['required', 'string', 'min:5', 'max:50'],
            'carnet_identidad' => ['required', 'string', 'min:7', 'max:15'],
            'fecha_nacimiento' => ['required', 'date', Rule::date()->format('Y-m-d')],
            'pais' => ['required', 'string', 'min:5', 'max:50'],
            'departamento' => ['required', 'string', 'min:4', 'max:50'],
            'ciudad' => ['required', 'string', 'min:5', 'max:50'],
            'zona' => ['required', 'string', 'min:5', 'max:50'],
            'calle' => ['required', 'string', 'min:5', 'max:100'],
            'numero_puerta' => ['required', 'string', 'min:1', 'max:10'],
            'email' => ['string', 'email', 'max:100'],
            'numero_celular' => ['required', 'string', 'min:7', 'max:15'],
            'fecha_contratacion' => ['required', 'date', Rule::date()->format('Y-m-d')],
            'salario' => ['required', 'numeric', 'max:999999.9999'],
            'departamento_id' => ['required', 'exists:departamentos,departamento_id'],
            'encargado_id' => ['nullable', 'exists:empleados,empleado_id'],
            'estado' => ['boolean', 'sometimes']
        ];
    }
}
