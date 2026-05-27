<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'maintenanceId'     => $this->maintenanceId,
            'tecId'             => $this->tecId,
            'name'              => "{$this->technician->firstname} {$this->technician->lastname}",
            'maintenanceDate'   => $this->maintenanceDate,
            'observations'      => $this->observations,
            'type'              => $this->type
        ];
    }
}
