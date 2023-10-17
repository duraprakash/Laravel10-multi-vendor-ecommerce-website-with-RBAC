{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        <div class="mb-4">
            <a href="{{ route('admin.create-role') }}" class="btn btn-primary">Create New Role</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Roles</h2>
                @foreach($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>{{ $role->name }}</h4>
                        </div>
                        <div class="card-body">
                            <h5>Assigned Permissions:</h5>
                            <ul>
                                @foreach($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('admin.edit-role', $role->id) }}" class="btn btn-warning">Edit Role</a>
                            <a href="{{ route('admin.delete-role', $role->id) }}" class="btn btn-danger">Delete Role</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-6">
                <h2>Permissions Grouped by Group Name</h2>
                @foreach($permissionsByGroup as $group => $permissions)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>{{ $group }}</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach($permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


{{-- old --}}
{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        <div class="mb-4">
            <a href="{{ route('admin.create-role') }}" class="btn btn-primary">Create New Role</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Roles</h2>
                @foreach($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>{{ $role->name }}</h4>
                        </div>
                        <div class="card-body">
                            <h5>Assigned Permissions:</h5>
                            <ul>
                                @foreach($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('admin.edit-role', $role->id) }}" class="btn btn-warning">Edit Role</a>
                            <a href="{{ route('admin.delete-role', $role->id) }}" class="btn btn-danger">Delete Role</a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-6">
                <h2>Permissions Grouped by Group Name</h2>
                @foreach($permissionsByGroup as $group => $permissions)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>{{ $group }}</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach($permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
