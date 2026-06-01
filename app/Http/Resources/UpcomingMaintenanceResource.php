<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpcomingMaintenanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assetId'               => $this->assetId,
            'internalId'            => $this->internalId,
            'model'                 => "{$this->assetModels?->brands?->brand} {$this->assetModels?->model_name}",
            'nextMaintenance'       => $this->nextMaintenance->format('Y-m-d'),
            'daysUntilMaintenance'  => $this->days_until_maintenance,
        ];
    }
}
