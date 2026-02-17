<?php

namespace App\Services;

// Models
use App\Models\User;
use App\Models\Computer;

class UserComputerAssignService 
{

    public function assignUser(Computer $computer, int $assignedId, int $assignedBy) {
        DB::transaction(function () use ($computer, $assignedId, $assignedBy) {

            // Invalidate previous active assignments
            $computer->userHistory()->where('status', assignmentStatus::ACTIVE)->update(['status' => assignmentStatus::INACTIVE, 'unassigmentDate' => now()]);

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
                'status' => AssignmentStatus::ACTIVE,
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
            ->where('status', AssignmentStatus::ACTIVE)
            ->update([
                'status'           => AssignmentStatus::INACTIVE,
                'unassignmentDate' => now()
            ]);

            $computer->update([
                'assignedUser' => null,
                'assignedBy'   => $performedBy
            ]);
        });
    }
}