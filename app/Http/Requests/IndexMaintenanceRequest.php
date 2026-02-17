<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexMaintenanceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'typeId'    => 'nullable|string|max:6|exists:maintenance_types,typeId',
            'date'      => 'nullable|date',
            'from'      => 'nulable|date',
            'to'        => 'nullable|date',
            'perPage'   => 'nullable|integer|max:50'
        ];
    }
}
