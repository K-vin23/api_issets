<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComputerBrandResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'brandId'   => $this->brandId,
            'brand'     => $this->brand
        ];
    }
}
