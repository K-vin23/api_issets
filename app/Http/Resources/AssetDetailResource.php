<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// Types
use App\Enums\ComponentType;
// Resources
use App\Http\Resources\RegisterUserResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\ModelsResource;

class AssetDetailResource extends JsonResource
{   
    public function toArray(Request $request): array
    {
        $processor = $this->components->first(fn($mp) => $mp->component?->compType?->categoryId === 'PROC')?->component;

        return [
            'assetId'       => $this->assetId,
            'id'            => $this->internalId,
            'model'         => ModelsResource::make($this->whenLoaded('assetModels')),
            'area'          => AreaResource::make($this->whenLoaded('area')),
            'categoryId'    => $this->typeId,
            'category'      => $this->type->assetType,
            'company'       => CompanyResource::make($this->whenLoaded('company')),
            'status'        => $this->assignedUser ? 'Asignado' : 'En Almacen',
            'serialNumber'  => $this->serialNumber,
            'responsable'   => UserListResource::make($this->whenLoaded('assignedTo')),
            'purchaseDate'  => $this->purchaseDate,
            'invoice'       => $this->invoice,
            // 'brand'         => $this->computerModel->computerBrand->brand,
            // 'model'         => $this->computerModel->model_name,
            $this->mergeWhen($this->isComputer(), [
                'networkName'   => $this->networkName,
                'processor'     => $processor ? [
                                    'id'    => $processor->componentId,
                                    'name'  => $processor->component
                                ] : null,
                'ram'           => $this->components
                                ->filter(fn($mc) => $mc->component?->compType?->categoryId === 'MEM')
                                ->map(fn($mc) => [
                                    'id'    => $mc->component?->componentId,
                                    'name'  => $mc->component?->component_name,
                                ])
                                ->values(),

                'storage'       => $this->components
                                ->filter(fn($mc) => $mc->component?->compType?->categoryId === 'STOR')
                                ->map(fn($mc) => [
                                    'id'    => $mc->component?->componentId,
                                    'name'  => $mc->component?->component_name,
                                ])
                                ->values(),
                'osLicense' => $this->licenses->map(fn($cl) => [
                    'licenseId'     =>  $cl->license->licenseId,
                    'licenseKey'    =>  $cl->licenseKey,
                    'softwareType'  =>  $cl->license->softwareType,
                ])->firstWhere('softwareType', 'SO'),
                'officeLicense' => $this->licenses->map(fn($cl) => [
                    'licenseId'     =>  $cl->license->licenseId,
                    'licenseKey'    =>  $cl->licenseKey,
                    'softwareType'  =>  $cl->license->softwareType,
                ])->firstWhere('softwareType', 'OFFI')
            ]),
            $this->mergeWhen($this->isMonitor() || $this->isUps(), [
                'details' => $this->details
            ]
            ),
        ];
    }
}
