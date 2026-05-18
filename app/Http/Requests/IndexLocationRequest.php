<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cityId'    => 'sometimes|required|string|max:6|exists:cities,cityId',
        ];
    }

    public function messages() 
    {
        return [
            'cityId.max'    => 'El id de la ciudad no puede superar los 6 caracteres',
            'cityId.exists' => 'La ciudad no existe',
        ];
    }
}
