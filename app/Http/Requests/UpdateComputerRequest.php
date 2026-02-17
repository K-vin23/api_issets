<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComputerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'internalId' => 'sometimes|string|max:100',
            'areaId'     => 'sometimes|integer|exists:areas,areaId',
            'modelId'    => 'sometimes|integer|exists:computer_models,modelId'
        ];
    }

    public function messages()
    {
        return [
            'internalId.max' => 'el id interno no puede superar los 100 caracteres',
            'areaId.exists'  => 'el area no existe',
            'modelId.exists' => 'el modelo no existe en el catalogo'
        ];
    }
}
