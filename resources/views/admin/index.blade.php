@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Roles and Permissions</h1>

        <div class="navbar-container mb-4">
            <button class="btn btn-info btn-responsive btn-responsive-left" onmousedown="scrollNavbar('left')"
                onmouseup="stopScroll()">&lt;</button>
            <div class="navbar" id="navbar">
                <div class="navbar-inner" id="navbarInner">
                    {{-- @for ($i = 1; $i < 10; $i++)
                        <a href="{{ route('admin.create-role') }}" class="btn btn-primary btn-responsive">Create New
                            Role {{ $i }}</a>
                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-responsive">Users
                            Management{{ $i }}</a>
                    @endfor --}}

                    <a href="{{ route('admin.create-role') }}" class="btn btn-primary btn-responsive">Create New Role</a>
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-responsive">Users Management</a>
                    @for ($i = 1; $i < 10; $i++)
                        <a href="{{ route('user.index') }}" class="btn btn-primary btn-responsive">Users Management</a>
                    @endfor
                </div>
            </div>
            <button class="btn btn-info btn-responsive btn-responsive-right" onmousedown="scrollNavbar('right')"
                onmouseup="stopScroll()">&gt;</button>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Roles</h2>
                @foreach ($roles as $role)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>{{ $role->name }}</h4>
                        </div>
                        <div class="card-body">
                            <h5>Assigned Permissions:</h5>
                            <ul>
                                @foreach ($role->permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('admin.edit-role', $role->id) }}" class="btn btn-warning">Edit Role</a>
                            <a href="{{ route('admin.delete-role', $role->id) }}" class="btn btn-danger">Delete
                                Role</a>
                            {{-- <!-- Update the "Delete Role" button in your Blade file -->
                            <a href="#" onclick="confirmDelete('{{ $role->name }}', {{ $role->id }})"
                                class="btn btn-danger">Delete Role</a> --}}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-6">
                {{-- <h2>Permissions Grouped by Group Name</h2> --}}
                <h2><b>List of permissions for each group</b></h2>
                @foreach ($permissionsByGroup as $group => $permissions)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3>Group: {{ $group }}</h3>
                        </div>
                        <div class="card-body">
                            <h5>Permissions...</h5>
                            <ul>
                                @foreach ($permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        let scrollInterval;

        function scrollNavbar(direction) {
            const navbar = document.getElementById('navbar');

            function scroll() {
                if (direction === 'left') {
                    navbar.scrollLeft -= 5; // Adjust the scroll distance as needed
                } else {
                    navbar.scrollLeft += 5; // Adjust the scroll distance as needed
                }
            }

            scrollInterval = setInterval(scroll, 10); // Adjust the interval as needed
        }

        function stopScroll() {
            clearInterval(scrollInterval);
        }
    </script>

    <style>
        /* hide horizontal scrollbar */
        #navbar {
            overflow-x: hidden;
        }

        /* diplay navbar horizontally */
        .navbar-container {
            /* overflow: hidden; */
            /* position: relative; */
            /* added */
            display: flex;
            align-items: center;
            overflow-x: hidden;
        }

        .navbar {
            /* overflow-x: auto; logout issue solved */
            white-space: nowrap;
            display: flex;
            align-items: center;
            /* padding: 0 10px; logout space issue solved */
            /* Adjust the padding as needed */
            /* added */
            /* flex-grow: 1; */
            /* overflow: hidden; */
        }

        .navbar-inner {
            display: flex;
            gap: 10px;
        }

        .btn-responsive {
            /* Adjust button styles as needed */
            font-size: 16px;
        }

        .btn-responsive-left,
        .btn-responsive-right {
            /* background-color: transparent; */
            border: none;
            cursor: pointer;
        }

        .btn-responsive-left {
            margin-right: 10px;
            /* Adjust margin as needed */
        }

        .btn-responsive-right {
            margin-left: 10px;
            /* Adjust margin as needed */
        }
    </style>
@endsection


{{-- <!-- Add this script to your Blade file -->
<script>
    function confirmDelete(roleName, roleId) {
        if (confirm(`Are you sure you want to delete the role "${roleName}"?`)) {

            // window.location.href = `{{ route('admin.delete-role', ['role' => '__roleId__']) }}`.replace('__roleId__',
            //     roleId);

            /**
             * Creates a hidden form element dynamically, adds the necessary CSRF token, 
             * and then submits the form using a POST/GET request. This helps improve security 
             * by ensuring that the action is performed through a POST/GET request with a valid CSRF token.
             */
            let form = document.createElement('form');
            form.action = `{{ route('admin.delete-role', ['role' => '__roleId__']) }}`.replace('__roleId__', roleId);
            form.method = 'GET';
            form.style.display = 'none';

            let csrfToken = document.createElement('input');
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script> --}}
