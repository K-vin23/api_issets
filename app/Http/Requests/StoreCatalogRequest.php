<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brandId'       => 'required|string|max:4|exists:computer_brands,brandId',
            'modelFamily'   => 'required|string|max:100',
            'modelSerie'    => 'sometimes|required|string|max:100',
            'processorId'   => 'required|integer|exists:processors,processorId'
        ];
    }
}
