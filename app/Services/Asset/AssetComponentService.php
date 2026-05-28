<?php
namespace App\Services\Asset;

use Illuminate\Support\Collection;
//Enums
use App\Enums\ChangeAction;
use App\Enums\ComponentType;
//Models
use App\Models\Asset;
use App\Models\AssetComponent;
use App\Models\Component;
use App\Models\AssetLicense;
use App\Models\ChangeAssetHistory;

class AssetComponentService
{
    public function __construct() { 
    }

    public function addComponents(array $data, Asset $asset) {
        // security check of components <-> asset type

        //Computers
        if($asset->isComputer()) {
            //Add memories
            if(!empty($data['memories'])) {
                foreach ($data['memories'] as $m){
                    AssetComponent::create([
                        'assetId'       => $asset->assetId,
                        'componentId'   => $m['id']
                    ]);
                }
            }
            //Add disks
            if(!empty($data['disks'])){
                foreach ($data['disks'] as $d){
                    AssetComponent::create([
                        'assetId'       => $asset->assetId,
                        'componentId'   => $d['id']
                    ]);
                }
            }
            //Add licenses
            if(!empty($data['licenses'])){
                foreach ($data['licenses'] as $l){
                    AssetLicense::create([
                        'assetId'       => $asset->assetId,
                        'licenseId'     => $l['licenseId'],
                        'licenseKey'    => $l['licenseKey']
                    ]);
                }
            }
        }

        // [...] more logic of asset components
    }

    public function changeComponents(array $data, Asset $asset, int $maintenanceId) {
        
        $currents = $asset->components()->pluck('componentId');
        
        $new = collect($data['memories'] ?? [])
                ->pluck('id')
                ->merge(
                    collect($data['disks'] ?? [])
                    ->pluck('id')
                );

        $currentCount = $currents->countBy();
        $newCount = $new->countBy();
        
        $removed = collect();
        $added = collect();

        $removed = $this->countComponents($currentCount, $newCount);
        $added = $this->countComponents($newCount, $currentCount);

        // Traer componentes
        $componentMap = Component::whereIn(
            'componentId',
            $added->merge($removed)->unique()
        )->get()->keyBy('componentId');

        $removed->each(function ($componentId) use ($asset, $maintenanceId, $componentMap) {

            $component = $componentMap[$componentId];

            ChangeAssetHistory::create([
                'assetId'           => $asset->assetId,
                'maintenanceId'     => $maintenanceId,
                'changeTypeId'      => ChangeAction::REMOVED->value,
                'description'       => $this->description($component, ChangeAction::REMOVED->value)
            ]);
        });

        $added->each(function ($componentId) use ($asset, $maintenanceId, $componentMap) {

            $component = $componentMap[$componentId];

            ChangeAssetHistory::create([
                'assetId'           => $asset->assetId,
                'maintenanceId'     => $maintenanceId,
                'changeTypeId'      => ChangeAction::ADDED->value,
                'description'       => $this->description($component, ChangeAction::ADDED->value)
            ]);
        });
    }

    private function countComponents(Collection $base, Collection $compare): Collection {
        $res = collect();

        $base->each(function ($qty, $componentId) use ($compare, $res) {
            $newQty = $compare->get($componentId, 0);

            if($qty > $newQty) {
                for($i = 0; $i < ($qty - $newQty); $i++){
                    $res->push($componentId);
                }
            }
        });

        return $res;
    }

    private function description(Component $component, string $action): String{
        if($component->componentType === ComponentType::MEM->value){
            return "Memoria: {$component->component_name} {$action} (edición)";
        }
        if($component->componentType === ComponentType::STOR->value){
            return "Disco duro: {$component->component_name} {$action} (edición)";
        }
    }


}