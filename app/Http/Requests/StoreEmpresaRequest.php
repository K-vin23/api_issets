<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_empresa' => 'required|string|max:|unique:pgsql.system.empresa', 
            'nombre' => 'required|string|max:50', 
            'id_ciudad' => 'required|string|max:4|unique:pgsql.system.ciudad', 
        ];
    }

    public function messages(): array
    {
        return [
            'id_empresa.required' => 'El campo id_empresa es obligatorio',
            'id_empresa.string' => 'El campo id_empresa no puede ser un número',       
            'id_empresa.max' => 'El campo id_empresa puede ser máximo de 6 caracteres',
            'id_empresa.unique' => 'El campo id_empresa ya existe',
            'nombre.required' => 'El campo nombre es obligatorio',
            'nombre.string' => 'El campo nombre no puede ser un número',
            'nombre.max' => 'El campo nombre puede ser máximo de 50 caracteres',       
            'id_ciudad.required' => 'El campo id_ciudad es obligatorio',
            'id_ciudad.string' => 'El campo id_ciudad no puede ser un número',
            'id_ciudad.max' => 'El campo id_ciudad puede ser máximo de 4 caracteres',
            'id_ciudad.unique' => 'El campo id_ciudad ya existe',
        ];
    }

}
