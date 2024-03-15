<?php

namespace App\Policies\V1;

use App\Models\Products;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('product.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Products $model): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('product.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Products $model): bool
    {
        return $user->hasPermissionTo('product.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Products $model): bool
    {
        return $user->hasPermissionTo('product.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Products $model): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Products $model): bool
    {
        //
    }
}
