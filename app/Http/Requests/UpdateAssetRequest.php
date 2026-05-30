<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAssetRequest extends FormRequest
{

    public function authorize(): bool{
        return true;
    }

    public function rules(): array
    {
        return [
            'serialNumber'          => 'sometimes|string|max:100',
            'networkName'           => 'sometimes|string|max:50',
            'companyId'             => 'sometimes|integer|exists:companies,companyId',
            'categoryId'            => 'sometimes|string|max:4',
            'invoice'               => 'sometimes|string|max:50',
            'purchaseDate'          => 'sometimes|date',
            'internalId'            => 'sometimes|string|max:100',     
            'areaId'                => 'sometimes|integer|exists:areas,areaId',
            'modelId'               => 'sometimes|integer|exists:models,modelId',
            'responsable'           => 'sometimes|integer|exists:users,userId',
            'memories'              => 'sometimes|array|max:3',
            'memories.*.id'         => 'sometimes|integer|exists:components,componentId',
            'disks'                 => 'sometimes|array|max:3',
            'disks.*.id'            => 'sometimes|required|exists:components,componentId',
            'licenses'              => 'sometimes|array',
            'licenses.*.licenseId'  => 'sometimes|required|exists:licenses,licenseId',
            'licenses.*.licenseKey' => 'sometimes|required|string',
            'details'               => 'sometimes|string|min:1|max:100'
            ];
    }

    public function messages()
    {
        return [
            'serialNumber.max' => 'El numero serial no puede superar los 200 caracteres.',
            'companyId.exists' => 'La empresa no existe.',
            'invoice.max' => 'La factura no puede superar los 50 caracteres.',
            'purchaseDate.date' => 'La fecha de compra debe ser una fecha válida.',
        ];
    }
}
