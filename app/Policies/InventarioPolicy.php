<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Inventario;
use App\Models\User;

class InventarioPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('gestionar-inventario');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inventario $inventario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inventario $inventario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inventario $inventario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inventario $inventario): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inventario $inventario): bool
    {
        return false;
    }
}
