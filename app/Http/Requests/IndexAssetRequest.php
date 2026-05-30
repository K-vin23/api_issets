<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexAssetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyId' => 'nullable|integer|exists:companies,companyId',
            'areaId'    => 'nullable|integer|exists:areas,areaId',
            'typeId'    => 'nullable|string|exists:asset_types,typeId',
            'status'    => 'nullable|string',
            'search'    => 'nullable|string|max:100',
            'perPage'   => 'nullable|integer|max:50',
        ];
    }
}
