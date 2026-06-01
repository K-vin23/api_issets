<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestoreCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'restoreAll' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'restoreAll.boolean'       => 'La opción de resturación solo puede ser verdadero o falso.'
        ];
    }

}
