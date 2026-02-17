<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'company.required'  => 'El nombre de la compania es obligatorio',
            'company.max'       => 'El nombre de la compania no puede superar los 100 caracteres'
        ];
    }

}
