<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RemovedAssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assetId'       => $this->assetId,
            'internalId'    => $this->internalId,
            'model'         => "{$this->assetModels->brands->brand} {$this->assetModels->model_name}",
            'category'      => $this->type->assetType,
            'removalDate'   => $this->latestRemoval?->removalDate,
            'reason'        => $this->latestRemoval?->removalReason,
        ];
    }
}
