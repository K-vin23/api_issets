<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeActivoEliminadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_activo' => 'required|string|max:30|unique:system.activo,id_activo',
            'id_empresa' => 'required|string|exists:system.empresa,id_empresa',
            'ultimo_usr' => 'required|integer|exists:system.usuario,cedula',
            'ultima_act' => 'nullable|date',
            'usr_registro' => 'required|integer|exists:system.usuario,cedula',
            'fecha_baja' => 'required|date',
            'razon_baja' => 'required|string|max:100'
        ];
    }

}
