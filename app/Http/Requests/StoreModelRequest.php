<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreModelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brandId'  => 'required|string|max:4|exists:brands,brandId',
            'model'    => 'required|string|max:200',
            'typeId'   => 'required|string|max:4|exists:asset_types,typeId'
        ];
    }

    public function messages(): array
    {
        return [
            'brandId.required'    => 'La marca es obligatorio',
            'brandId.max'         => 'La marca no puede superar los 4 caracteres',
            'model.required'      => 'El nombre del modelo es obligatorio',
            'model.max'           => 'EL modelo no puede superar los 200 caracteres',
            'typeId.required'     => 'El tipo de activo es obligatorio',
            'typeId.max'          => 'El tipo de activo no puede superar los 4 caracteres'
        ];
    }

}
