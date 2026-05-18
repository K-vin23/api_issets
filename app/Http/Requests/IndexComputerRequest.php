<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexComputerRequest extends FormRequest
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
            'status'    => 'nullable|string',
            'search'    => 'nullable|string|max:100',
            'perPage'   => 'nullable|integer|max:50',
        ];
    }
}
