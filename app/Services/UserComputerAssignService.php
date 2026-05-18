<?php

namespace App\Services;

// Enums
use App\Enums\AssignmentStatus;
// Models
use App\Models\User;
use App\Models\Computer;
use App\Models\ComputerUsersHistory;
//Utilities
use Illuminate\Support\Facades\DB;

class UserComputerAssignService 
{

    public function assignUser(Computer $computer, int $assignedId, int $assignedBy) {
        DB::transaction(function () use ($computer, $assignedId, $assignedBy) {

            // Invalidate previous active assignments 
            // $computer->userHistory()->where('status', assignmentStatus::ACTIVE->value)->update(['status' => assignmentStatus::INACTIVE->value, 'unassigmentdate' => now()]);
            // obtain user info
            $user = User::findOrFail($assignedId);
            
            // Assign new user
            $computer->assignUser($assignedId, $assignedBy);

            // Log assignment in history
            $computer->userHistory()->create([
                'computerId'  => $computer->computerId,
                'userId'     => $user->userId,
                'userName'   => $user->getFullName(),
                'assignmentDate' => now(),
                'status' => AssignmentStatus::ACTIVE->value,
                'unnasigmentdate'   => null
            ]);
        });
    }
    
    public function unassignAllFromUser(User $user, int $performedBy) {
        $computers = Computer::where('assignedUser', $user->userId)->get();

        foreach ($computers as $computer) {
            $this->unassign($computer, $performedBy);
        }
    }

    public function unassign(Computer $computer, int $performedBy) {
        DB::transaction(function() use ($computer, $performedBy) {
            $computer->userHistory()
            ->where('status', AssignmentStatus::ACTIVE->value)
            ->update([
                'status'           => AssignmentStatus::INACTIVE->value,
                'unassignmentdate' => now()
            ]);

            $computer->update([
                'assignedUser' => null,
                'assignedBy'   => $performedBy
            ]);
        });
    }


}