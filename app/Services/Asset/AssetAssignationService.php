<?php

namespace App\Services\Asset;

// Enums
use App\Enums\AssignmentType;
// Models
use App\Models\User;
use App\Models\Asset;
use App\Models\AssetAssignationHistory;
//Utilities
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssetAssignationService 
{
    public function assign(Asset $asset, int $responsable, int $register) {
        DB::transaction(function () use ($asset, $responsable, $register) {
            // Found responsable
            $responsable2 = User::findOrFail($responsable);

            // Found register
            $register2 = User::findOrFail($register);

            // Found if transferred/
            $isTransferred = $asset->usersHistory()->count();

            if ($isTransferred > 0) {
                $asset->usersHistory()->create([
                    'assetId'           => $asset->assetId,
                    'assignationType'   => AssignmentType::TRANSF,
                    'serialNumber'      => $asset->serialNumber,
                    'userId'            => $responsable2->userId,
                    'userName'          => $responsable2->getFullName(),
                    'assignedBy'        => $register2->userId,
                    'assignName'        => $register2->getFullName(),
                    'assignmentDate'    => now(),
                    'unassignmentDate'   => null
                ]);
            } else {
                $asset->usersHistory()->create([
                    'assetId'           => $asset->assetId,
                    'assignationType'   => AssignmentType::ASIGN,
                    'serialNumber'      => $asset->serialNumber,
                    'userId'            => $responsable2->userId,
                    'userName'          => $responsable2->getFullName(),
                    'assignedBy'        => $register2->userId,
                    'assignName'        => $register2->getFullName(),
                    'assignmentDate'    => now(),
                    'unassignmentDate'   => null
                ]);
            }

            $asset->update([
                'assignedUser'  => $responsable,
                'updatedBy'     => $register,
                'lastUpdate'    => now()->format('Y-m-d')
            ]);
        });
    }

    public function unassign(Asset $asset, int $register) {
        DB::transaction(function() use ($asset, $register) {
            $reg = $asset->usersHistory()
                    ->where('userId', $asset->assignedUser)
                    ->whereIn('assignationType', [AssignmentType::ASIGN, AssignmentType::TRANSF])
                    ->latest('assignmentDate')
                    ->first();
            if(!empty($reg)) {
                $reg->update([
                    'assignationType'   => AssignmentType::REM,
                    'unassignmentdate'  => now()
                ]);
            }
            $asset->update([
                'assignedUser'  => null,
                'updateBy'      => $register,
            ]);
        });
    }
    
    public function unassignAll(User $user, int $register) {
        // Security Check
        if(!($user->isActive)){
            $assets = Asset::where('assignedUser', $user->userId)->get();
            
            foreach ($assets as $asset) {
                $this->unassign($asset);
            }
        }

        
    }
}