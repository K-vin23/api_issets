<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userId' => 'required|integer',
            'pw_encrypt' => 'required|string'
        ];
    }

     public function messages(): array
    {
        return [
            'userId.required' => 'La cédula es obligatoria.',
            'userId.integer' => 'La cédula debe ser un número entero.',
            'pw_encrypt.required' => 'La contraseña es obligatoria.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Datos inválidos',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
