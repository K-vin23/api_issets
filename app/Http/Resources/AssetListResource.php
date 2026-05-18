<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assetId'       => $this->assetId,
            'internalId'    => $this->internalId,
            'model'         => "{$this->assetModels->brands->brand} {$this->assetModels->model_name}",
            'category'      => $this->type->assetType,
            'company'       => $this->company->company,
            'status'        => $this->assignedUser ? 'Asignado' : 'En almacen',
        ];
    }
}
