<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// Resources
use App\Http\Resources\AuthUserResource;

class AuthResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'user'  => new AuthUserResource($this['user']),
            'token' => $this['token'],
        ];
    }
}
