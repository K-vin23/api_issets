<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ComputerModelResource;
use App\Http\Resources\RegisterUserResource;
use App\Http\Resources\AssetResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ComputerResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'computerId'    => $this->computerId,
            'internalId'    => $this->internalId,
            'area'          => AreaResource::make($this->whenLoaded('area')),
            'model'         => ComputerModelResource::make($this->whenLoaded('computerModel')),
            'assignedUser'  => RegisterUserResource::make($this->whenLoaded('assignedUser')) ?? null,
            'assignedBy'    => RegisterUserResource::make($this->whenLoaded('assignedByUser')) ?? null,
            'lastUpdate'    => $this->lastUpdate,
            'asset'         => AssetResource::make($this->whenLoaded('asset'))
        ];
    }
}
