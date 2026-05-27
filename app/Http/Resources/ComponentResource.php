<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ComponentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->componentId,
            'name'          => $this->component_name
        ];
    }
}
