<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand'  => 'required|string|max:50'
        ];
    }

    public function messages(): array
    {
        return [
            'brand.required'    => 'La marca es obligatorio',
            'brand.max'         => 'La marca no puede superar los 50 caracteres'
        ];
    }

}
