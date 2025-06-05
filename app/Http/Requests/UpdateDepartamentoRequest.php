<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

class UpdateDepartamentoRequest extends FormRequest
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
            'nombre_departamento' => [ 'string', 'min:4', 'max:20'],
            'encargado_id' => ['integer', 'nullable', 'sometimes', 'exists:empleados,empleado_id', 'unique:departamentos,encargado_id'],
            'subdepartamento_de' => ['integer', 'nullable', 'sometimes', 'exists:departamentos,departamento_id'],
        ];
    }
}
