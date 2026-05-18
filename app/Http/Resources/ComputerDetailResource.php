<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
// Resources
use App\Http\Resources\RegisterUserResource;

class ComputerDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'computerId'    => $this->computerId,
            'id'            => $this->internalId,
            'networkName'   => $this->networkName,
            'modelId'       => $this->modelId,
            'name'          => $this->computerModel->computerBrand->brand . ' ' . $this->computerModel->model_name,
            'categoryId'    => $this->asset->assetType,
            'category'      => $this->asset->type->assetType,
            'companyId'     => $this->asset->companyId,
            'company'       => $this->asset->company->company,
            'status'        => $this->assignedUser ? 'Asignado' : 'En Almacen',
            'serialNumber'  => $this->asset->serialNumber,
            'responsable'   => RegisterUserResource::make($this->whenLoaded('userAssigned')),
            'brand'         => $this->computerModel->computerBrand->brand,
            'model'         => $this->computerModel->model_name,
            'processor'     => $this->computerModel->processor->getProcessor(),
            'purchaseDate'  => $this->asset->purchaseDate,
            'invoiceNumber' => $this->asset->invoice,
            'areaId'        => $this->areaId,
            'area'          => $this->area->area,
            'ram'           => $this->memories->map(fn($mem) => [
                'id'            => $mem->memory?->memoryId,
                // 'internalId'    => $mem->id
            ]),
            'storage'       => $this->disks->map(fn($disk) => [
                'id'            => $disk->disk?->diskId,
                // 'internalId'    => $disk->id
            ]),
            'osLicense' => $this->licenses->map(fn($cl) => [
                // 'internalId'    =>  $cl->id,
                'licenseId'     =>  $cl->license->licenseId,
                'licenseKey'    =>  $cl->licenseKey,
                'softwareType'  =>  $cl->license->softwareType,
            ])->firstWhere('softwareType', 'SO'),
            'officeLicense' => $this->licenses->map(fn($cl) => [
                // 'internalId'    =>  $cl->id,
                'licenseId'     =>  $cl->license->licenseId,
                'licenseKey'    =>  $cl->licenseKey,
                'softwareType'  =>  $cl->license->softwareType,
            ])->firstWhere('softwareType', 'OFFI')
        ];
    }
}
