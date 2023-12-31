<?php

namespace App\Policies;

use App\Models\User as User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user?->role?->hasPermissionTo('UserResource.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return bool|null
     */
    public function view(User $user, User $model): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.view');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool|null
     */
    public function create(User $user): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return bool|null
     */
    public function update(User $user, User $model): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool|null
     */
    public function delete(User $user, User $model): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.delete');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return bool|null
     */
    public function restore(User $user, User $model): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool|null
     */
    public function forceDelete(User $user, User $model): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.forceDelete');
    }

    /**
     * Determine whether the user can mass delete models.
     *
     * @param User $user
     * @return bool|null
     */
    public function massDelete(User $user): bool|null
    {
        return $user?->role?->hasPermissionTo('UserResource.massDelete');
    }
}
