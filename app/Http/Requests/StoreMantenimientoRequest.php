<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMantenimientoRequest extends FormRequest
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
            'id_activo' => 'required|string|max:30|exists:pgsql.system.activo',
            'id_empresa' => 'required|string|max:6|exists:pgsql.system.empresa',
            'id_tipomnt' => 'required|string|max:4|exists:pgsql.system.tipo_mantenimiento',
            'fecha_manten' => 'required|date',
            'proximo_manten' => 'nullable|date',
            'usr_manten' => 'required|integer|exists:pgsql.system.usuario,cedula',
            'ultima_act' => 'required|date',
            'observaciones' => 'sometimes|string|max:260'
        ];
    }

    public function messages()
    {
        return [
            'id_activo.required' => 'El ID del activo es obligatorio.',
            'id_activo.exists' => 'El ID del activo no existe.',
            'id_activo.max' => 'El ID del activo no puede ser mayor de 30 caracteres',
            'id_empresa.exists' => 'La empresa no existe.',
            'id_empresa.max' => 'El ID de la empresa no puede ser mayor a 6 caracteres.',
            'id_tipomnt.exists' => 'El tipo de mantenimiento no existe.',
            'id_tipomnt.max' => 'El tipo de mantenimiento no puede ser mayor a 4 caracteres.',
            'fecha_manten.required' => 'La fecha del mantenimiento es obligatoria',
            'usr_manten.exists' => 'El usuario que registra el mantenimiento no existe',
            'observaciones.max' => 'Las observaciones no puede superar los 260 caracteres.',
        ];
    }
}
