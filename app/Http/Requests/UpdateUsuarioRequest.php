<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
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
            'cedula' => ['sometimes', 'string',
                                Rule::unique('pgsql.system.usuario', 'cedula') //verificar que el id_activo sea unico
                                ->ignore($this->cedula, 'cedula') //excluir el registro
                            ],
            'id_tipousr' => 'sometimes|string|exists:pgsql.system.tipo_usuario',
            'nombre_completo' => 'sometimes|string|max:100',
            'correo' => 'sometimes|email|max:100',
            'id_ciudad' => 'sometimes|string|max:4|exists:pgsql.system.ciudad',
            'pwd_encrypt' => 'sometimes|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'cedula.unique' => 'La cedula ya existe',
            'id_tipousr.exists' => 'El tipo de usuario no existe',
            'cedula.numeric' => 'el campo cedula debe ser un numero entero',
            'nombre_completo.string' => 'el campo nombre_completo no puede ser un numero',
            'id_tipousr.string' => 'el campo id_tipousr no puede ser un numero',
            'correo.email' => 'debe ser un correo electronico',
            'nombre_completo.max' => 'El nombre no puede ser mayor de 100 caracteres',
            'correo.max' => 'El correo no puede ser mayor de 100 caracteres',
            'id_ciudad.max' => 'el ID de la ciudad no puede superar los 4 caracteres.',
            'pwd_encrypt.min' => 'La contrasena debe ser mayor de 6 caracteres',
        ];
    }
}
