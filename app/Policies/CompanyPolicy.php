<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function view(User $user, Company $company): bool
    {
        return in_array($user->rolId, ['TEC', 'ADM']);
    }

    public function create(User $user): bool
    {
        return $user->rolId === 'ADM';
    }

    public function update(User $user, Company $company): bool
    {
        return $user->rolId === 'ADM';;
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->rolId === 'ADM';
    }

    public function restore(User $user, Company $company): bool
    {
        return $user->rolId === 'ADM';
    }

    public function forceDelete(User $user, Company $company): bool
    {
        return $user->rolId === 'ADM';
    }
}
