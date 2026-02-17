<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array(auth()->user()->rolId, ['ADM', 'TEC']);
    }

    public function rules(): array
    {
        $user = auth()->user();

        $rules = [
            'firstname'  => 'sometimes|string|max:50',
            'middlename' => 'sometimes|string|max:50',
            'lastname'   => 'sometimes|string|max:50|',
            's_lastname' => 'sometimes|string|max:50',
            'email'      => 'sometimes|email|max:100',
        ];
        
        // Block to Technician
        $rules['rolId'] = ['prohibited'];
        $rules['companyId'] = ['prohibited'];
        $rules['areaId'] = ['prohibited'];
        $rules['locationId'] = ['prohibited'];

        if($user->isAdmin()) {
            $rules['rolId'] = ['sometimes', 'string', 'exists:roles,rolId'];
            $rules['companyId'] = ['sometimes', 'integer', 'exists:companies,companyId'];
            $rules['areaId'] = ['sometimes', 'integer', 'exists:areas,areaId'];
            $rules['locationId'] = ['sometimes', 'integer', 'exists:locations,locationId'];
            
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'rolId.prohibited'     => 'No se puede modificar el rol del usuario',
            'rolId.exists'         => 'El rol no existe',
            'companyId.prohibited' => 'No se puede modificar la empresa del usuario',
            'companyId.exists'     => 'La empresa no existe',
            'firstname.max'        => 'El nombre no puede superar los 50 caracteres',
            'middlename.max'       => 'El segundo nombre no puede superar los 50 caracteres',
            'lastname.max'         => 'El apellido no puede superar los 50 caracteres',
            'email.max'            => 'El correo no puede superar los 100 caracteres',  
            'areaId.prohibited'    => 'No se puede modificar el area del usuario',          
            'areaId.exists'        => 'El area no existe',
            'locationId.prohibited'=> 'No se puede modificar la localizacion del usuario',
            'locationId.exists'    => 'La localizacion no existe'
        ];
    }
}
