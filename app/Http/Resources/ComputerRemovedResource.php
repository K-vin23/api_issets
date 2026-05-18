<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComputerRemovedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->removedId,
            'internalId'    => $this->removedComputer->internalId,
            'name'          => $this->removedComputer->brand . ' ' . $this->removedComputer->model,
            'category'      => $this->assetType,
            'removalDate'   => $this->removalDate,
            'removalReason' => $this->removedComputer->removalReason
        ];
    }
}
