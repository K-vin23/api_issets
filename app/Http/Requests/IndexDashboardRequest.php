<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexDashboardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'companyId' => 'nullable|integer|exists:companies,companyId',
            'areaId'    => 'nullable|integer|exists:areas,areaId'
        ];
    }
}
