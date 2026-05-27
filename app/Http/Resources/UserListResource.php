<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'initials'  => strtoupper(mb_substr($this->firstname, 0, 1). mb_substr($this->lastname, 0, 1)),
            'userId'    => $this->userId,
            'name'      => $this->getFullName(),
            'email'     => $this->email,
            'company'   => $this->company->company,
            'rol'       => $this->rolId,
            'status'    => $this->is_active_label
        ];
    }
}
