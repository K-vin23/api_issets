<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UpcomingMaintenanceResource;

class DashboardResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'totals'                => $this['totals'],
            'assetsByArea'          => $this['assetsByArea']
        ];
    }
}
