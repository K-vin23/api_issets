<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUsuarioRequest extends FormRequest
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
            'cedula' => 'required|numeric|unique:pgsql.system.usuario',
            'id_tipousr' => 'required|string|max:4|exists:pgsql.system.tipo_usuario', //OK hay que especificar conexión pgsql para schemas.
            'id_empresa' => 'required|string|max:5|exists:pgsql.system.empresa',
            'nombre_completo' => 'required|string|max:100',
            'correo' => 'required|email|max:100', //hacer el correo unico en la bd
            'id_ciudad' => 'required|string|max:4|exists:pgsql.system.ciudad',
            'pwd_encrypt' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'cedula.numeric' => 'La cédula debe ser un número entero.',
            'cedula.required' => 'La cédula es obligatoria.',
            'id_tipousr.required' => 'El tipo de usuario es obligatorio',
            'id_empresa.required' => 'El id de empresa es obligatorio',
            'nombre_completo.required' => 'El nombre del usuario es obligatorio',
            'ciudad.required' => 'La ciudad es obligatoria',
            'pwd_encrypt.required' => 'La contraseña es obligatoria.',
            'cedula.unique' => 'El usuario con la cédula ya existe.',
            'correo.unique' => 'Ese correo ya esta registrado',
            'id_tipousr.exists' => 'El tipo de usuario no existe',
            'id_empresa.exists' => 'La empresa no existe',
            'id_tipousr.max' => 'El tipo de usuario debe ser maximo 4 caracteres',
            'id_empresa.max' => 'El id de la empresa debe ser maximo 5 caracteres',
            'nombre_completo.max' => 'El nombre no puede superar los 100 caracteres',
            'correo.max' => 'El correo no puede superar los 100 caracteres',
            'ciudad.max' => 'La ciudad no puede superar los 100 caracteres',
            'pwd_encrypt.min' => 'La contraseña debe ser mayor de 6 caracteres',
        ];
    }
}
