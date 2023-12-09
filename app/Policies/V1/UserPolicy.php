<?php

namespace App\Policies\V1;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        // return $user->hasRole('Super-Admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $targetUser)
    {
        // return $user->id === $targetUser->id || $user->role === 'Super-Admin';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // return $user->hasPermissionTo('user.create');
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $targetUser)
    {
        // return $user->id === $targetUser->id || $user->role === 'Super-Admin';
        return $user->hasRole('super-admin') || $user->hasPermissionTo('user.edit-user');
        // return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $targetUser)
    {
        return $user->id !== $targetUser->id && $user->role === 'Super-Admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $targetUser): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $targetUser): bool
    {
        //
    }
}
