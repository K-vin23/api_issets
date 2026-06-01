<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCompanyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'    => 'nullable|string',
            'search'    => 'nullable|string|max:100',
            'perPage'   => 'nullable|integer',
        ];
    }
}
