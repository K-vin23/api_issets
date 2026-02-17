<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCatalogRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brandId'   => 'nullable|string|max:4|exists:computer_brands,brandId',
            'search'    => 'nullable|string|max:200'
        ];
    }
}
