<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'assetId'       => $this->assetId,
            'serialNumber'  => $this->serialNumber,
            'company'       => CompanyResource::make($this->whenLoaded('company')),
            'assetType'     => $this->whenLoaded('type', fn() => [
                                    'id'        => $this->type->typeId,
                                    'assetType' => $this->type->assetType
                                ]),
            'invoice'       => $this->invoice,
            'purchaseDate'  => $this->purchaseDate,
            'registeredBy'  => RegisterUserResource::make($this->whenLoaded('registerUser'))
        ];
    }
}
