<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userId'     => 'required|integer',
            'rolId'      => 'required|string|max:4|exists:roles,rolId',
            'companyId'  => 'required|integer|exists:companies,companyId',
            'firstname'  => 'required|string|max:50',
            'middlename' => 'sometimes|string|max:50',
            'lastname'   => 'required|string|max:50|',
            's_lastname' => 'sometimes|string|max:50',
            'email'      => 'nullable|email|max:100',
            'pw_encrypt' => 'required|string|min:8',
            'areaId'     => 'required|integer|exists:areas,areaId',
            'locationId' => 'nullable|integer|exists:locations,locationId',
            'registBy'   => 'nullable|integer|exists:users,userId'
        ];
    }

    public function messages(): array
    {
        return [
            'userId.required'      => 'La identificación es obligatoria',
            'rolId.required'       => 'El usuario debe tener un rol',
            'rolId.exists'         => 'El rol no existe',
            'companyId.required'   => 'El usuario debe pertenecer a una empresa',
            'companyId.exists'     => 'La empresa no existe',
            'firstname.required'   => 'El nombre es obligatorio',
            'firstname.max'        => 'El nombre no puede superar los 50 caracteres',
            'middlename.max'       => 'El segundo nombre no puede superar los 50 caracteres',
            'lastname.required'    => 'El apellido es obligatorio',
            'lastname.max'         => 'El apellido no puede superar los 50 caracteres',
            's_lastname.max'       => 'El segundo apellido no puede superar los 50 caracteres',
            'email.max'            => 'El correo no puede superar los 100 caracteres',            
            'pw_encrypt.required'  => 'La contrasena es obligatorio',
            'pw_encrypt.min'       => 'La contrasena no puede ser inferior a 8 caracteres',
            'areaId.required'      => 'El usuario debe pertenecer a un area',            
            'areaId.exists'        => 'El area no existe',
            'locationId.exists'    => 'La localizacion no existe',
            'registBy.exists'      => 'El usuario que registra no existe',
        ];
    }
}
