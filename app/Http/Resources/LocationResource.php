<?php

namespace App\Http\Resources;

use App\Http\Resources\CityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'locationId' => $this->locationId,
            'location'   => $this->locationName,
            'city'       => CityResource::make($this->whenLoaded('city')), 
        ];
    }
}
