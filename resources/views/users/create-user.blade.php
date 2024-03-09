<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Create User</h1>
            <div class="mb-4">
                <a href="{{ route('users.index') }}" class="btn btn-danger">Go Back</a>
            </div>
            <!-- Form to create a new user -->
            <form action="{{ route('users.store-user') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="roles">Roles:</label>
                    <div class="card-body">
                        <div class="row border-black">
                            @foreach ($roles as $role)
                                <div class="col-md-6 col-sm-6 col-6">
                                    <div class="form-check" @required(true)>
                                        <input class="form-check-input permission-checkbox" type="checkbox" name="roles[]"
                                            value="{{ $role->name }}" data-group="" id="role_{{ $role->id }}">
                                        <label class="form-check-label permission-label" for="role_{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <br><br>
                            <label for="add-new-role">Don't have role that you are looking for? Don't worry you can add your
                                own role and assign various permisisons right away.</label>
                            <a href="{{ route('roles.create-role') }}" class="btn btn-success btn-responsive">Add New
                                Role</a>
                        </div>
                    </div>
                </div>

                @can('create', \App\Models\User::class)
                    <div class="mb-4 mt-3">
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                @endcan

            </form>
        </div>
    @endsection
    <style>
        .border-black {
            border: 1px solid black;
            padding: 15px;
        }

        .card-body {
            margin: 0 12px;
        }
    </style>
</div>
