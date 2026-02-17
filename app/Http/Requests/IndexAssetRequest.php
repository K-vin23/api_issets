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
            'assetType' => 'nullable|string|exists:asset_types,typeId',
            'search'    => 'nullable|string|max:100',
            'perPage'   => 'nullable|integer|max:50',
        ];
    }
}
