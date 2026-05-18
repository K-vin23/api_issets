<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComputerListResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'computerId'    => $this->computerId,
            'internalId'    => $this->internalId,
            'name'          => $this->computerModel->computerBrand->brand . ' ' . $this->computerModel->model_name,
            'category'      => $this->asset->type->assetType,
            'company'       => $this->asset->company->company,
            'status'        => $this->assignedUser ? 'Asignado' : 'En Almacen',
            'isActive'      => $this->isActive,
        ];
    }
}
