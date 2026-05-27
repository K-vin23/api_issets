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
            'rolId'         => $this->rolId,
            'firstname'     => $this->firstname,
            'middlename'    => $this->middlename,
            'lastname'      => $this->lastname,
            'secondLastname'=> $this->s_lastname,
            'email'         => $this->email,
            'registDate'    => $this->registDate,
            'companyId'     => $this->companyId,
            'cityId'        => $this->location->cityId,
            'areaId'        => $this->areaId,
            'locationId'    => $this->locationId,
            'status'        => $this->is_active_label
        ];
    }
}
