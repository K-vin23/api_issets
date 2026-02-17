<?php

namespace App\Http\Resources;

use App\Http\Resources\LocationResource;
use App\Http\Resources\RolResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'userId'    => $this->userId,
            'rol'       => RolResource::make($this->whenLoaded('rol')),
            'name'      => trim($this->getFullName()),
            'email'     => $this->email,
            'registDate'=> $this->registDate,
            'registBy'  => RegisterUserResource::make($this->whenLoaded('registeredBy')),
            'company'   => CompanyResource::make($this->whenLoaded('company')),
            'area'      => $this->whenLoaded('area', fn() => [
                                'areId'    => $this->area->areaId,
                                'area'  => $this->area->area, 
                            ]),
            'location'  => LocationResource::make($this->whenLoaded('location'))
        ];
    }
}
