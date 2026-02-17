<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rolId'      => 'prohibited',
            'companyId'  => 'prohibited',
            'firstname'  => 'sometimes|string|max:50',
            'middlename' => 'sometimes|string|max:50',
            'lastname'   => 'sometimes|string|max:50|',
            's_lastname' => 'sometimes|string|max:50',
            'email'      => 'sometimes|email|max:100',
            'areaId'     => 'prohibited',
            'locationId' => 'prohibited',
        ];
    }

    public function messages()
    {
        return [
            'rolId.prohibited'     => 'No se puede modificar el rol del usuario',
            'companyId.prohibited' => 'No se puede modificar la empresa del usuario',
            'firstname.max'        => 'El nombre no puede superar los 50 caracteres',
            'middlename.max'       => 'El segundo nombre no puede superar los 50 caracteres',
            'lastname.max'         => 'El apellido no puede superar los 50 caracteres',
            'email.max'            => 'El correo no puede superar los 100 caracteres',            
            'areaId.prohibited'    => 'No se puede modificar el area del usuario',
            'locationId.prohibited'=> 'No se puede modificar la localizacion del usuario'
        ];
    }
}
