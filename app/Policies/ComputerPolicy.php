<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class ComputerPolicy
{
    public function viewAny(?User $user)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $user, Computer $computer)
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function create(User $user)
    {
        return in_array($user->rolId, ['ADM']);
    }

    public function update(User $user, Computer $computer)
    {
        return in_array($user->rolId, ['ADM']);
    }

    public function delete(User $user, Computer $computer)
    {
        return in_array($user->rolId, ['ADM']);
    }

    public function restore(User $user, Computer $computer)
    {
        return in_array($user->rolId, ['ADM']);
    }

    public function forceDelete(User $user, Computer $computer)
    {
        return in_array($user->rolId, ['ADM']);
    }
}
