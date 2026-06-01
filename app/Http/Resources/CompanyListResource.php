<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'companyId' => $this->companyId,
            'company'   => $this->company,
            'status'    => $this->status
        ];
    }
}
