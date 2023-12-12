<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\User\DeleteUserRequest;
use App\Http\Requests\V1\User\StoreUserRequest;
use App\Http\Requests\V1\User\UpdateUserRequest;
use App\Http\Resources\V1\User\UserResource;
use App\Models\User;
use Exception;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\alert;

class UserController extends Controller
{

    public function __construct(User $user)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $this->authorize('viewAny', $user);
        // $user->hasPermissionTo('view articles');
        // $usertype = User::all();;
        // return $usertype[1]->name;
        $users = User::all();
        // $user = UserResource::collection($user)->toJson();

        // foreach($users as $user){
        //     echo $user->id .' | ';
        //     echo $user->name . ' | ';
        //     echo implode(', ', $user->roles->pluck('name')->toArray());
        //     echo ''.'<br>';
        // }

        // return UserResource::collection($user);
        return view('user.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // blank
        $roles = Role::all();
        return view('user.create-user', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, Role $role)
    {
        try {
            // $user = User::create($request->validate());

            // return new UserResource($user);
            // return new UserResource(User::create($request->all())); // only this line of code 

            $newUser = new UserResource(User::create($request->all())); // only this line of code 
            // return view('user.create-user');

            // Create the user
            // $user = User::create($request->except('roles'));

            // Assign roles to the user
            // $newUser->assignRole($request->input('roles', []));
            $newUser->syncRoles($request->input('roles', []));

            return Redirect::route('user.index')->with('success', 'User created successfully');
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'Failed to crete user.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);

        // if (!$user) {
        //     return response()->json(['message' => 'User not found'], 404);
        // }
        // return new UserResource($user); // only this line of code
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit-user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        // auth()->$user->hasPermissionTo('view articles');

        // $user->update($request->validated());

        // return new UserResource($user);

        // $user->update($request->all()); // only this line of code
        // $users = $user->all();
        // return view('user.index', compact('users'));

        try {
            // Update the user details
            $user->update($request->except('roles'));

            // Sync roles with the user
            $user->syncRoles($request->input('roles', []));

            // Respond with the updated user resource
            // return new UserResource($user);
            return Redirect::route('user.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            // Handle any errors during the update
            return response()->json(['error' => 'Error updating user'], 500);
        }
    }

    public function deleteUser(User $user)
    {
        $this->authorize('delete', $user);
        return view('user.delete-user', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(DeleteUserRequest $request, User $user)
    {
        /*
        // // Ensure the authenticated user owns the customer
        // if (Auth::id() !== $customer->user_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        *
        * only this block code
        */
        try {
            // Delete the user
            $user->delete();

            // Respond with a success message
            // return response()->json(['message' => 'User deleted successfully'], 200);
            return redirect()->route('user.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json(['error' => 'Error deleting user'], 500);
        }
    }
}
