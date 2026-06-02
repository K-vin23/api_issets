<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelsResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'modelId'   => $this->modelId,
            'brand'     => $this->brands?->brand,
            'brandId'   => $this->brandId,
            'model'     => $this->model_name,
        ];
    }
}
