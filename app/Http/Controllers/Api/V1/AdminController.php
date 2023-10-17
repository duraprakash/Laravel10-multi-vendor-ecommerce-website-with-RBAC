<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        // $roles = Role::all();
        // $permissionsByModel = Permission::all()->groupBy('model_name');
        // $permission_groups = Permission::all()->groupBy('group_name');

        // return view('admin.index', compact('roles', 'permissionsByModel', 'permission_groups'));

        $roles = Role::all();
        $permissionsByGroup = Permission::all()->groupBy('group_name');

        return view('admin.index', compact('roles', 'permissionsByGroup'));
    }

    public function createRole()
    {
        return view('admin.create-role');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return Redirect::route('admin.index');
    }

    public function editRole(Role $role)
    {
        $permissionsByModel = Permission::all()->groupBy('model_name');
        $permissionsByGroup = Permission::all()->groupBy('group_name');
        $role->load('permissions');

        return view('admin.edit-role', compact('role', 'permissionsByGroup')); //, 'permissionsByModel'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return Redirect::route('admin.index');
    }

    public function deleteRole(Role $role)
    {
        return view('admin.delete-role', compact('role'));
    }

    public function destroyRole(Role $role)
    {
        $role->delete();

        return Redirect::route('admin.index');
    }
}
