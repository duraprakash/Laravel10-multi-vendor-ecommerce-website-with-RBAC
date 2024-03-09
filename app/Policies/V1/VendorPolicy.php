<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Models\Vendors;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('vendor.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('vendor.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Vendors $model): bool
    {
        return $user->hasPermissionTo('vendor.edit');
        // return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Vendors $model): bool
    {
        return $user->hasPermissionTo('vendor.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Vendors $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Vendors $model): bool
    {
        //
    }
}
