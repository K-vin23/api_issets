<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignComponentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'componentId'  => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'componentId.required'    => 'El componente es obligatorio',
        ];
    }

}
