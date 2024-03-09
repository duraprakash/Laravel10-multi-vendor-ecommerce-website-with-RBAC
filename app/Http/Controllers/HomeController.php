<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(User $user)
    {
        // // return view('home');
        // $roles = Role::all();
        // $permissionsByModel = Permission::all()->groupBy('model_name');
        // $permission_groups = Permission::all()->groupBy('group_name')->toArray();

        // return view('admin.index', compact('roles', 'permissionsByModel', 'permission_groups')); 



        // $user = auth()->user();

        $res = null;
        // Check if the user has a specific role
        if ($user->hasRole('admin')) {
            $users = User::all();
            $res = view('users.index', compact('users'));
        } elseif ($user->hasRole('super-admin')) {
            $roles = Role::all();
            $permissionsByGroup = Permission::all()->groupBy('group_name');
            $res = view('roles.index', compact('roles', 'permissionsByGroup'));
        } elseif ($user->hasRole('vendor')) {
            $vendors = Vendors::all();
            $res = view('vendors.index', compact('vendors'));
        } else {
            // The user doesn't have any of the specified roles
            $users = User::all();
            $res = view('users.index', compact('users'));
        }
        return $res;
        // return view('admin.index', compact('roles', 'permissionsByGroup'));
    }
}
