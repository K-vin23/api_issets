<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Usuario $user)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Usuario $user, Usuario $usuario)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']) || $user->cedula === $usuario->cedula;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Usuario $user)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Usuario $user, Usuario $usuario)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Usuario $user, Usuario $usuario)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Usuario $user, Usuario $usuario)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Usuario $user, Usuario $usuario)
    {
        return in_array($user->rol, ['TEC', 'ADMS', 'ADMG']);
    }
}
