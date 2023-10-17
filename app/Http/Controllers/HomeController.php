<?php

namespace App\Http\Controllers;

use App\Models\User;
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
    public function index()
    {
        // // return view('home');
        // $roles = Role::all();
        // $permissionsByModel = Permission::all()->groupBy('model_name');
        // $permission_groups = Permission::all()->groupBy('group_name')->toArray();

        // return view('admin.index', compact('roles', 'permissionsByModel', 'permission_groups')); 

        $roles = Role::all();
        $permissionsByGroup = Permission::all()->groupBy('group_name');

        return view('admin.index', compact('roles', 'permissionsByGroup'));
    }
}
