<?php

namespace App\Policies;

use App\Models\User as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Role as Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool|null
     */
    public function viewAny(User $user): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Role $model
     * @return bool|null
     */
    public function view(User $user, Role $model): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool|null
     */
    public function create(User $user): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Role $model
     * @return bool|null
     */
    public function update(User $user, Role $model): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Role $model
     * @return bool|null
     */
    public function delete(User $user, Role $model): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Role $model
     * @return bool|null
     */
    public function restore(User $user, Role $model): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Role $model
     * @return bool|null
     */
    public function forceDelete(User $user, Role $model): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.forceDelete');
    }

    /**
     * Determine whether the user can mass delete models.
     *
     * @param User $user
     * @return bool|null
     */
    public function massDelete(User $user): bool|null
    {
        return $user?->role?->hasPermissionTo('RoleResource.massDelete');
    }
}
