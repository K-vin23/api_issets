<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyId'     => 'nullable|integer|exists:companies,companyId',
            'rolId'         => 'nullable|string|min:3|exists:roles,rolId',
            // 'areaId'        => 'nullable|integer|exists:areas,areaId',
            // 'locationId'    => 'nullable|integer|exists:locations,locationId',
            'status'        => 'nullable|string|min:2',
            'search'        => 'nullable|string|max:100',
            'perPage'       => 'nullable|integer|max:50'
        ];
    }
}
