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
            'model'         => "{$this->brand} {$this->model}",
            'category'      => $this->assetType,
            'removalDate'   => $this->removalDate,
            'reason'        => $this->removalReason,
        ];
    }
}
