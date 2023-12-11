<?php

namespace App\Policies\V1;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Spatie\Permission\Models\Role;

class UserPolicy1
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
    public function viewAny(User $user, Role $role) //: Response
    {
        dd('ViewAny called'); // Add this line for debugging
        return $user->hasPermissionTo('view articles');
        // ? Response::allow()
        // : Response::deny('You do not have permission to view.');
        // // return $user->hasRole('Super-Admin')
        // return $user->id === $role->user_id // ; verify that the user's id matches the user_id on the role or
        //     ? Response::allow()
        //     : Response::deny('You do not own this role.'); // return a more detailed response or
        // //     // : Response::denyWithStatus(404); // customizing the HTTP Response Status or
        // //     // : Response::denyAsNotFound(); // the denyAsNotFound method is offered for convenience or
        // // return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $targetUser)
    {
        // return $user->id === $targetUser->id || $user->role === 'Super-Admin';
        return $user->id === $targetUser->id || $user->hasRole('Super-Admins');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        // return $user->hasPermissionTo('user.create');
        // return true;
        return $user->hasPermissionTo('create-post');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $targetUser)
    {
        dd('Update method called'); // Add this line for debugging
        dd($user->id, $targetUser->id, $user->hasRole('Super-Admins')); // Add this line for more details

        return $user->id === $targetUser->id || $user->hasRole('Super-Admins');
        // return false; //($user->is_admin || $user->id === $targetUser->id);
        // return $user->id === $targetUser->id || $user->role === 'Super-Admin';
        // return $user->hasRole('super-admin') || $user->hasPermissionTo('user.edit-user');
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

    public function debugUpdate(User $user, User $targetUser)
    {
        return true; // Always allow for debugging
    }
}
