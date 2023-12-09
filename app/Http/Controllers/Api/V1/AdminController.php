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

    public function createRole(Role $role)
    {
        $roles = Role::all();
        $permissionsByGroup = Permission::all()->groupBy('group_name');
        $role->load('permissions');
        return view('admin.create-role', compact('roles', 'permissionsByGroup', 'role'));
    }

    public function storeRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ]);

        // Create a new role
        $newRole = Role::create(['name' => $request->name]);

        // Sync permissions with the new role
        $newRole->syncPermissions($request->permissions ?? []);


        return Redirect::route('admin.index')->with('success', 'Role created successfully.');
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

        return Redirect::route('admin.index')->with('success', 'Role updated successfully.');
    }

    public function deleteRole(Role $role)
    {
        return view('admin.delete-role', compact('role'));
    }

    public function destroyRole(Role $role)
    {
        $role->delete();

        // return Redirect::route('admin.index');
        return redirect()->route('admin.index')->with('success', 'Role deleted successfully.');
    }
}
