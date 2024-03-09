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
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

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
        // if (auth()->id()) {
        //     return  auth()->id();
        // } else {
        //     return "nothing found";
        // }
        return view('users.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        $this->authorize('create', $user);
        $roles = Role::all();
        return view('users.create-user', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, User $user, Role $role)
    {
        try {
            // // $user = User::create($request->validate());

            // // return new UserResource($user);
            // // return new UserResource(User::create($request->all())); // only this line of code 

            // $newUser = new UserResource(User::create($request->all())); // only this line of code 
            // // return view('user.create-user');

            // // Create the user
            // // $user = User::create($request->except('roles'));

            // // Assign roles to the user
            // // $newUser->assignRole($request->input('roles', []));
            // $newUser->syncRoles($request->input('roles', []));

            /**
             * Store user info along with the profile image
             */
            $data = $request->validated();

            // Handle profile image upload and resize if needed
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = $this->generateFilename($file);

                // $file->move(public_path('upload/user_images'), $filename); // store in public
                $file->storeAs('public', 'upload/user_images/' . $filename); // store in storage

                $data['profile_image'] = $filename;
            } else {
                $data['profile_image'] = 'default.jpg';
            } // ends

            // assign user role if role is not given
            if ($request->input('role') == null) {
                // Assign the default role if no roles are provided
                $defaultRole = 'user'; // Adjust based on your default role
                $data['roles'] = $request->input('roles', [$defaultRole]);

                // Create the user
                $newUser = User::create($data);

                // Assign roles to the user
                $newUser->syncRoles($data['roles']);
                return Redirect::route('users.index')->with('success', 'User created successfully');
            } // ends
            else {
                User::create($data);
                return Redirect::route('users.index')->with('success', 'User created successfully');
            }
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['error' => 'Failed to create user.', $e], 500);
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
        // $this->authorize('update', $user);
        $roles = Role::all();
        return view('users.edit-user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        // // auth()->$user->hasPermissionTo('view articles');

        // // $user->update($request->validated());

        // // return new UserResource($user);

        // // $user->update($request->all()); // only this line of code
        // // $users = $user->all();
        // // return view('user.index', compact('users'));

        // try {
        //     // Update the user details
        //     $user->update($request->except('roles'));

        //     // Sync roles with the user
        //     $user->syncRoles($request->input('roles', []));

        //     // Respond with the updated user resource
        //     // return new UserResource($user);
        //     return Redirect::route('users.index')->with('success', 'User updated successfully');
        // } catch (\Exception $e) {
        //     // Handle any errors during the update
        //     return response()->json(['error' => 'Error updating user'], 500);
        // }


        try {
            $data = $request->validated();
            
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $this->deleteOldProfileImage($user);
                $file = $request->file('profile_image');
                $filename = $this->generateFilename($file);

                /**
                 * 
                 * Store Image in Storage Folder
                 * $file->storeAs('public/upload/user_images', $filename);
                 * 
                 * Store Image in Public Folder
                 * $file->move(public_path('public/upload/user_images'), $filename);
                 * 
                 * Store Image in S3
                 * $file->storeAs('public/upload/user_images', $filename, 's3');
                 * 
                 */

                // $file->move(public_path('upload/user_images'), $filename); // store in public
                $file->storeAs('public', 'upload/user_images/' . $filename); // store in storage

                $data['profile_image'] = $filename;
            }

            $user->update($data);

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (Exception $e) {
            return response()->json(['error' => 'Error updating user'], 500);
        }
    }

    // private function deleteOldProfileImage(User $user)
    // {
    //     try{
    //         if ($user->profile_image && $user->profile_image !== 'default.jpg') {
    //             Storage::delete('public/upload/user_images/' . $user->profile_image);
    //             return redirect()->route('users.index')->with('success', 'Old pic deleted successfully');
    //         }
    //         return redirect()->route('users.index')->with('error', 'Old pic not deleted');
    //     } catch(Exception $e){
    //        return redirect()->route('users.index')->with('error', 'User updated successfully');
    //     }
    // }

    // work with this
    private function deleteOldProfileImage($user)
    {
        try {
            if ($user->profile_image && $user->profile_image !== 'default.jpg') {
                // Delete the old profile image from storage
                Storage::delete('public/upload/user_images/' . $user->profile_image);

                // Update the user record to remove the profile image
                $user->update(['profile_image' => null]);

                // return redirect()->route('users.index')->with('success', 'Old pic deleted successfully');
            // } else if($user->profile_image == 'default.jpg'){
            //     return redirect()->route('users.index')->with('error', 'Default pic cannot be deleted');
            // } else{
            //     return redirect()->route('users.index')->with('error', 'No pic found to delete');
            }
        } catch (Exception $e) {
            return redirect()->route('users.index')->with('error', 'Error deleting old pic');
        }
    }

    private function generateFilename($file)
    {
        $currentDateTime = now()->format('YmdHis');
        $originalFilename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $filename = $currentDateTime . '_' . Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '.' . $extension;

        return $filename;
    }

    public function uploadProfilePic(Request $request, User $user)
    {
        $this->authorize('update', $user);
        // // auth()->$user->hasPermissionTo('view articles');

        try {
            // $data = $request->validated();
            
            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                
                // delete old pic before updating
                $this->deleteOldProfileImage($user);

                $file = $request->file('profile_image');
                $filename = $this->generateFilename($file);
                
                /**
                 * 
                 * Store Image in Storage Folder
                 * $file->storeAs('public/upload/user_images', $filename);
                 * 
                 * Store Image in Public Folder
                 * $file->move(public_path('public/upload/user_images'), $filename);
                 * 
                 * Store Image in S3
                 * $file->storeAs('public/upload/user_images', $filename, 's3');
                 * 
                 */
                
                // $file->move(public_path('upload/user_images'), $filename); // store in public
                $file->storeAs('public', 'upload/user_images/' . $filename); // store in storage
                
                $data['profile_image'] = $filename;
                

                // // try if update doesn't work
                // // Update the user's profile_image field in the database
                // $user->profile_image = $filename;
                // $user->save();
                $user->update($data);
                return redirect()->route('users.index')->with('success', 'User profile pic updated successfully');
            }
            return redirect()->back()->with('error', 'No image file provided');
        } catch (Exception $e) {
            // return response()->json(['error' => 'Error updating user profile pic'], 500);
            return redirect()->route('users.index')->with('error', 'Error updating user profile pic ');
        }
    }

    public function deleteUser(User $user)
    {
        $this->authorize('delete', $user);
        return view('users.delete-user', compact('user'));
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
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json(['error' => 'Error deleting user'], 500);
        }
    }
}
