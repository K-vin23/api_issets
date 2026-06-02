<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComponentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ctypeId'   => 'required|integer|exists:component_type,ctypeId',
            'component' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'ctypeId.required'    => 'El tipo es obligatorio',
            'component.required'  => 'El nombre del componente es obligatorio'
        ];
    }

}
