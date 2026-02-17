<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serialNumber' => 'sometimes|string|max:200',
            'companyId' => 'sometimes|integer|exists:companies,companyId',
            'assetType' => 'sometimes|string|max:4|exists:asset_types,typeId',
            'invoice' => 'sometimes|string|max:50',
            'purchaseDate' => 'sometimes|date',
            'registeredBy' => 'required|integer|exists:users,userId'
            ];
    }

    public function messages()
    {
        return [
            'serialNumber.max' => 'El numero serial no puede superar los 200 caracteres.',
            'companyId.exists' => 'La empresa no existe.',
            'assetType.exists' => 'El tipo de activo no existe.',
            'invoice.max' => 'La factura no puede superar los 50 caracteres.',
            'purchaseDate.date' => 'La fecha de compra debe ser una fecha válida.',
            'registeredBy.exists' => 'Debe existir un usuario que registre el cambio',
        ];
    }
}
