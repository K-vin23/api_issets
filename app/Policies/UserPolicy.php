<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(?User $user) {
        return $user !== null && in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $authUser, User $user) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }

    public function me(User $authUser) {
        return true;
    }

    public function create(User $authUser) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }

    public function update(User $authUser, User $user) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }

    public function delete(User $authUser, User $user) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }

    public function restore(User $authUser, User $user) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }

    public function forceDelete(User $authUser, User $user) {
        return in_array($authUser->rolId, ['TEC', 'ADM']);
    }
}
