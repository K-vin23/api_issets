<?php

namespace App\Http\Resources;

use App\Http\Resources\LocationResource;
use App\Http\Resources\RolResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'cedula'        => $this->cedula,
            'rol'           => RolResource::make($this->whenLoaded('rol')),
            'firstname'     => $this->firstname,
            'middlename'    => $this->middlename,
            'lastname'      => $this->lastname,
            'secondLastname'=> $this->s_lastname,
            'email'         => $this->email,
            'registDate'    => $this->registDate,
            'registBy'      => UserListResource::make($this->whenLoaded('registeredBy')),
            'company'       => CompanyResource::make($this->whenLoaded('company')),
            'area'          => $this->whenLoaded('area', fn() => [
                                'areaId'    => $this->area->areaId,
                                'area'  => $this->area->area, 
                            ]),
            'location'      => LocationResource::make($this->whenLoaded('location')),
            'status'        => $this->is_active_label
        ];
    }
}
