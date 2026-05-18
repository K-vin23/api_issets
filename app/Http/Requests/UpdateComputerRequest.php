<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComputerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'serialNumber'  => 'sometimes|string|max:30',
            'networkName'   => 'sometimes|string|max:50',
            'companyId'     => 'sometimes|integer|exists:companies,companyId',
            'assetType'     => 'sometimes|string|max:4|exists:asset_types,typeId',
            'invoice'       => 'sometimes|string|max:50',
            'purchaseDate'  => 'sometimes|date',
            'internalId'    => 'sometimes|string|max:100',
            'areaId'        => 'sometimes|integer|exists:areas,areaId',
            'modelId'       => 'sometimes|integer|exists:computer_models,modelId',
            'assignedUser'  => 'sometimes|nullable|exists:users,userId',
            'memories'      => 'nullable|array|max:3',
            'memories.*.id' => 'sometimes|required|exists:memories,memoryId',
            'disks'         => 'nullable|array|max:3',
            'disks.*.id'    => 'sometimes|required|exists:hard_disks,diskId',
            'licenses'      => 'nullable|array',
            'licenses.*.licenseId'  => 'sometimes|required|exists:licenses,licenseId',
            'licenses.*.licenseKey' => 'sometimes|required|string'
        ];
    }

    public function messages()
    {
        return [
            'internalId.max' => 'el id interno no puede superar los 100 caracteres',
            'areaId.exists'  => 'el area no existe',
            'modelId.exists' => 'el modelo no existe en el catalogo'
        ];
    }
}
