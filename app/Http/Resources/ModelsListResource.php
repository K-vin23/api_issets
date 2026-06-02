<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelsListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'modelId'       => $this->modelId,
            'typeId'        => $this->typeId,
            'brandId'       => $this->brandId,
            'brand'         => $this->brands->brand,
            'model'         => $this->model_name,
            'processor'     => $this->modelComponents
                            ->filter(fn($pr) => $pr->component?->compType?->categoryId === 'PROC')
                                ->map(fn($mc) => [
                                    'id'   => $mc->component?->componentId,
                                    'name'     => $mc->component?->component_name,
                                ])
                                ->values()
        ];
    }
}
