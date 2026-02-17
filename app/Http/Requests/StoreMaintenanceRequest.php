<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'assetId'         => 'required|integer|exists:assets,assetId',
            'typeId'          => 'required|string|max:6|exists:maintenance_types,typeId',
            'maintenanceDate' => 'required|date',
            'nextMaintenance' => 'nullable|date',
            'tecId'           => 'required|integer|exists:users,userId',
            'observations'    => 'sometimes|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'assetId.required'         => 'El activo es obligatorio',
            'assetId.exists'           => 'El activo no existe',
            'typeId.exists'            => 'El tipo de mantenimiento no existe.',
            'typeId.max'               => 'El tipo de mantenimiento no puede superar los 6 caracteres.',
            'maintenanceDate.required' => 'La fecha del mantenimiento es obligatoria',
            'tecId.required'           => 'El tecnico es obligatorio',
            'tecId.exists'             => 'El usuario que registra el mantenimiento no existe',
            'observations.max'         => 'Las observaciones no puede superar los 100 caracteres.'
        ];
    }
}
