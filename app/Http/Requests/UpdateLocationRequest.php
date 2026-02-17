<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyId'     => 'sometimes|required|integer|exists:companies,companyId',
            'cityId'        => 'sometimes|required|string|max:6|exists:cities,cityId',
            'locationName'  => 'sometimes|required|string|max:40'
        ];
    }

    public function messages(): array
    {
        return [
            'companyId.exists'  => 'La compania no existe',
            'cityId.max'        => 'El id de la ciudad no puede superar los 6 caracteres',
            'cityId.exists'     => 'La ciudad no existe',
            'locationName.max'  => 'El nombre no puede superar los 40 caracteres'
        ];
    }
}
