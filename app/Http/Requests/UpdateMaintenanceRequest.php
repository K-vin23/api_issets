<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMantenimientoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'typeId'          => 'nullable|string|max:6|exists:maintenance_types,typeId',
            'maintenanceDate' => 'nullable|date',
            'nextMaintenance' => 'nullable|date',
            'tecId'           => 'nullable|integer|exists:users,userId',
            'observations'    => 'nullable|string|max:100'
        ];
    }

    public function messages()
    {
        return [
            'typeId.exists'        => 'El tipo de mantenimiento no existe.',
            'typeId.max'           => 'El tipo de mantenimiento no puede superar los 6 caracteres.',
            'maintenanceDate.date' => 'El valor debe ser una fecha',
            'nextMaintenance'      => 'El valor debe ser una fecha',
            'tecId'                => 'El usuario que registra el mantenimiento no existe',
            'observations.max'     => 'Las observaciones no pueden superar los 100 caracteres.'
        ];
    }
}
