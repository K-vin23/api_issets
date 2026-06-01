<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'userId'    => $this->userId,
            'name'      => $this->getFullName(),
            'email'     => $this->email,
            'rol'       => $this->rolId
        ];
    }
}
