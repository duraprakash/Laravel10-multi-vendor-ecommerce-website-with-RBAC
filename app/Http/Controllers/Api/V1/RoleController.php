<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Role $role)
    {
        // $roles = Role::all();
        // $permissionsByModel = Permission::all()->groupBy('model_name');
        // $permission_groups = Permission::all()->groupBy('group_name');

        // return view('admin.index', compact('roles', 'permissionsByModel', 'permission_groups'));
        $this->authorize('viewAny', $role);
        $roles = Role::all();
        $permissionsByGroup = Permission::all()->groupBy('group_name');

        return view('roles.index', compact('roles', 'permissionsByGroup'));
    }

    public function createRole(Role $role)
    {
        $this->authorize('create', $role);
        $roles = Role::all();
        $permissionsByGroup = Permission::all()->groupBy('group_name');
        $role->load('permissions');
        return view('roles.create-role', compact('roles', 'permissionsByGroup', 'role'));
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


        return Redirect::route('roles.index')->with('success', 'Role created successfully.');
    }

    public function editRole(Role $role)
    {
        $this->authorize('update', $role);
        $permissionsByModel = Permission::all()->groupBy('model_name');
        $permissionsByGroup = Permission::all()->groupBy('group_name');
        $role->load('permissions');

        return view('roles.edit-role', compact('role', 'permissionsByGroup')); //, 'permissionsByModel'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return Redirect::route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function deleteRole(Role $role)
    {
        $this->authorize('delete', $role);
        // return view('roles.delete-role', compact('role'));
    }

    public function destroyRole(Role $role)
    {
        $this->authorize('delete', $role);
        // $role->delete();

        // return Redirect::route('admin.index');
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
