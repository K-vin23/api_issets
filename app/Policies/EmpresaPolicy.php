<?php

namespace App\Policies;

use App\Models\Empresa;
use App\Models\Usuario;
use Illuminate\Auth\Access\Response;

class EmpresaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user)
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Empresa $empresa)
    {
        return in_array($user->rol, ['TEC', 'ADMS']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user)
    {
        return in_array($user->rol, ['ADMS']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Empresa $empresa)
    {
        return in_array($user->rol, ['ADMS']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Empresa $empresa)
    {
        return in_array($user->rol, ['ADMS']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Empresa $empresa)
    {
        return in_array($user->rol, ['ADMS']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Empresa $empresa)
    {
        return in_array($user->rol, ['ADMS']);
    }
}
