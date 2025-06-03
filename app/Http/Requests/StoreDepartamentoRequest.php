<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\Rule;

class StoreDepartamentoRequest extends FormRequest
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
            'nombre_departamento' => [
                'string', 
                'min:4', 
                'max:20', 
                Rule::unique('departamentos', 'nombre_departamento')->ignore($this->route('id'), 'departamento_id')],
            'encargado_id' => ['integer', 'nullable', 'sometimes', 'exists:empleados,empleado_id'],
        ];
    }
}
