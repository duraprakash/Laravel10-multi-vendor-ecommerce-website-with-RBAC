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
use Spatie\Permission\Models\Role;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('viewAny', User::class);

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
        $this->authorize('create', User::class);

        try {

            // $user = User::create($request->validate());

            // return new UserResource($user);
            // return new UserResource(User::create($request->all())); // only this line of code 

            $user = new UserResource(User::create($request->all())); // only this line of code 
            // return view('user.create-user');

            // Create the user
            // $user = User::create($request->except('roles'));

            // Assign roles to the user
            $user->assignRole($request->input('roles', []));

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
        $this->authorize('view', $user);

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
        $this->authorize('update', $user);
        $roles = Role::all();
        return view('user.edit-user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // $this->authorize('update', $user);

        // $user->update($request->validated());

        // return new UserResource($user);

        $user->update($request->all()); // only this line of code
        $users = $user->all();
        return view('user.index', compact('users'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        // return response()->noContent();

        // echo 'Deleting the user: ' . $user->name;
        // alert('Deleting the user: ' . $user->name);
        // $users = $user->all();
        return view('user.delete-user', compact('user'));
        // return Redirect::route('/users')->with('success', 'Item created successfully!');

        /*
        // // Ensure the authenticated user owns the customer
        // if (Auth::id() !== $customer->user_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        *
        * only this block code
        *
        try {
            // Delete the user
            $user->delete();

            // Respond with a success message
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json(['error' => 'Error deleting user'], 500);
        }
        */
    }




    // /// new one
    // public function index()
    // {
    //     $users = User::all();
    //     return view('user.create-user', compact('users'));
    // }

    // public function create()
    // {
    //     $roles = Role::all();
    //     return view('user.create', compact('roles'));
    // }

    // public function store(StoreUserRequest $request)
    // {
    //     $user = User::create($request->all());
    //     $user->roles()->sync($request->input('roles', []));
    //     return redirect()->route('auth.users.index')->with('success', 'User created successfully');
    // }

    // public function show(User $user)
    // {
    //     return view('user.show', compact('user'));
    // }

    // public function edit(User $user)
    // {
    //     $roles = Role::all();
    //     return view('user.edit', compact('user', 'roles'));
    // }

    // public function update(UpdateUserRequest $request, User $user)
    // {
    //     $user->update($request->all());
    //     $user->roles()->sync($request->input('roles', []));
    //     return redirect()->route('auth.users.index')->with('success', 'User updated successfully');
    // }

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return redirect()->route('auth.users.index')->with('success', 'User deleted successfully');
    // }
}
