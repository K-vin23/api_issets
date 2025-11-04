<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivoRequest extends FormRequest
{

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
            'id_activo' => ['sometimes', 'string',
                                Rule::unique('pgsql.system.activo', 'id_activo') //verificar que el id_activo sea unico
                                ->where(fn ($query) => $query->where('id_empresa', $this->id_empresa)) //limitarlo a la misma empresa
                                ->ignore($this->id_activo, 'id_activo') //excluir el registro
                            ],
            'id_tipoact' => 'sometimes|string|exists:system.tipo_activo,id_tipoact',
            'id_modelo' => 'sometimes|integer|exists:system.modelos_activo,id_modelo',
            'usr_asignado' => 'sometimes|integer|exists:system.usuario,cedula',
            'usr_registro' => 'required|integer|exists:system.usuario,cedula',
            'factura_compra' => 'sometimes|string|max:50',
            'fecha_compra' => 'sometimes|date',
            'ultima_act' => 'required|date'
            ];
    }

    public function messages()
    {
        return [
            'id_activo.max' => 'El ID del activo no puede ser superior a 30 caracteres',
            'usr_asignado.exists' => 'El usuario asignado no existe.',
            'id_modelo.exists' => 'El modelo no existe.',
            'usr_asignado.exists' => 'El usuario asignado no existe',
            'usr_registro.exists' => 'Debe existir un usuario que registre el cambio',
            'factura_compra.max' => 'La factura no puede superar los 50 caracteres.',
            'ultima_act.required' => 'Debe registrarse la fecha de actualizacion',
        ];
    }
}
