<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ComputerBrandResource;
use App\Http\Resources\ProcessorResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ComputerModelResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'modelId'   => $this->modelId,
            'brand'     => ComputerBrandResource::make($this->whenLoaded('computerBrand')),
            'processor' => ProcessorResource::make($this->whenLoaded('processor')),
            'model'     => $this->getModelName()
        ];
    }
}
