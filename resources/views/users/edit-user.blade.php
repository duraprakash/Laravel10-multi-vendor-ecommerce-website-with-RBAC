<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->

    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Edit User: {{ $user->name }}</h1>
            <div class="mb-4">
                <a href="{{ route('users.index') }}" class="btn btn-danger">Go Back</a>
            </div>
            <!-- Form to edit an existing user -->
            <form action="{{ route('users.update-user', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}"
                        required>
                </div>
                {{-- Display current profile picture --}}
                @if ($user->profile_image)
                    <div class="mb-3">
                        <label for="current-profile-image">Current Profile Picture:</label><br>
                        <img src="{{ !empty($user->profile_image) ? url('upload/user_images/' . $user->profile_image) : url('upload/user_images/default.jpg') }}"
                            alt="Profile Picture" class="img-thumbnail rounded img-fluid" height="200px"
                            width="350px">Public Folder
                        <img src="{{ asset('storage/upload/user_images/' . $user->profile_image) }}" alt="Profile Picture"
                            class="img-thumbnail round img-fluid" height="200px" width="350px">Storage Folder
                    </div>
                @endif
                <div class="form-group">
                    <label for="profile-image">Profile Image:</label>
                    <input type="file" class="form-control" id="profile-image" name="profile_image"
                        value="{{ asset('images/' . $user->profile_image) }}">
                </div>
                {{-- <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                </div> --}}
                {{-- <div class="form-group">
                    <label for="roles">Roles:</label>
                    <select multiple class="form-control" id="roles" name="roles[]" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="form-group">
                    <label for="roles">Roles:</label>
                    <div class="card-body">
                        <div class="row border-black">
                            @foreach ($roles as $role)
                                <div class="col-md-6 col-sm-6 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input permission-checkbox" type="checkbox" name="roles[]"
                                            value="{{ $role->name }}" data-group="" id="role_{{ $role->id }}"
                                            {{ $user->roles->contains($role) ? 'checked' : '' }}>
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

                @can('update', $user)
                    <div class="mb-4 mt-3">
                        <button type="submit" class="btn btn-primary">Update User</button>
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
