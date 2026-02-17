<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cityId'        => 'required|string|max:6|exists:cities,cityId',
            'locationName'  => 'required|string|max:40'
        ];
    }

    public function messages(): array 
    {
        return [
            'cityId.required'       => 'La localizacion debe ser de una ciudad especifica',
            'cityId.max'            => 'El id de la ciudad no puede superar los 6 caracteres',
            'cityId.exists'         => 'La ciudad no existe',
            'locationName.required' => 'El nombre de la localizacion es obligatorio',
            'locationName.max'      => 'El nombre no puede superar los 40 caracteres'
        ];
    }
}
