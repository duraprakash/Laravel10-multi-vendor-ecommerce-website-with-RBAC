{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2>Roles</h2>
                    </div>
                    <div class="card-body">
                        @foreach ($roles as $role)
                            <div class="mb-3">
                                <h4>{{ $role->name }}</h4>
                                <a href="{{ route('admin.edit-role', $role->id) }}" class="btn btn-warning">Edit Role</a>
                                <a href="{{ route('admin.delete-role', $role->id) }}" class="btn btn-danger">Delete Role</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header">
                        <h2>Permissions</h2>
                    </div>
                    <div class="card-body">
                        <h3>Permissions Grouped by Model Name</h3>
                        @foreach ($permissionsByModel as $model => $permissions)
                            <div class="mb-3">
                                <h4>{{ $model }}</h4>
                                <ul>
                                    @foreach ($permissions as $permission)
                                        <li>{{ $permission->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



<!-- Second part -->
{{-- resources/views/admin/index.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        <div class="mb-4">
            <a href="{{ route('admin.create-role') }}" class="btn btn-primary">Create New Role</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2>Roles</h2>
            </div>
            <div class="card-body">
                @foreach ($roles as $role)
                    <div class="mb-3">
                        <h5>{{ $role->name }}</h5>
                        <p><strong>Permissions:</strong></p>
                        <ul>
                            @forelse($role->permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty
                                <li>No permissions assigned</li>
                            @endforelse
                        </ul>
                        <div class="btn-group">
                            <a href="{{ route('admin.edit-role', $role->id) }}" class="btn btn-warning">Edit Role</a>
                            <a href="{{ route('admin.delete-role', $role->id) }}" class="btn btn-danger">Delete Role</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Permissions Grouped by Model Name</h2>
            </div>
            <div class="card-body">
                @foreach ($permissionsByModel as $model => $permissions)
                    <div class="mb-3">
                        <h3>{{ $model }}</h3>
                        <ul>
                            @forelse($permissions as $permission)
                                <li>{{ $permission->name }}</li>
                            @empty
                                <li>No permissions defined</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


<!-- third part -->
