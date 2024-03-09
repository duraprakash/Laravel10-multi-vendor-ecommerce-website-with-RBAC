<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->

    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>User Management</h1>
            @auth
                @php
                    $userRoles = auth()
                        ->user()
                        ->getRoleNames()
                        ->toArray();
                @endphp
                <p>User Role: {{ implode(', ', $userRoles) }}</p>
            @endauth

            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">Go Back</a>
                <a href="{{ route('users.create-user') }}" class="btn btn-success">Create New User</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Sno.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profile Image</th>
                        <th>Role</th>
                        <th class="text-center" colspan="2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($users as $user)
                        <tr>
                            {{-- <td>{{ $user->id }}</td> --}}
                            <td>{{ $count++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                {{-- <img src="{{ asset('images/' . $user->profile_image) }}" alt="Profile Picture" width="100px"
                                    height="50px"> --}}
                                {{-- <img src="{{ asset('images/' . $user->profile_image) }}" alt="{{ $user->name }}"
                                    class="img-thumbnail" width="80"> --}}
                                @if ($user->profile_image)
                                    <img src="{{ asset('upload/user_images/' . $user->profile_image) }}"
                                        alt="{{ $user->name }}'s Profile Image" class="img-thumbnail"
                                        width="80">ImgAsset
                                @else
                                    <p>No profile image available 1st</p>
                                @endif

                                @if ($user->profile_image)
                                    @php
                                        $imagePath = public_path('upload/user_images/' . $user->profile_image);
                                    @endphp

                                    @if (file_exists($imagePath))
                                        <img src="{{ asset('upload/user_images/' . $user->profile_image) }}"
                                            alt="{{ $user->name }}'s Profile Image" class="img-thumbnail"
                                            width="80px">fileExistAsset
                                    @else
                                        <p>No profile image file found 2nd</p>
                                    @endif
                                @else
                                    <p>No profile image available 3rd</p>
                                @endif
                                <p>File Path: {{ public_path('images/' . $user->profile_image) }}</p>
                                <p>File Path:
                                    {{ public_path('upload/user_images/' . $user->profile_image) }}</p>
                                <img id="showImage"
                                    src="{{ !empty($user->profile_image) ? url('upload/user_images/' . $user->profile_image) : url('upload/user_images/default.jpg') }}"
                                    alt="User" style="width:100px; height: 100px;">Public Folder
                                <img src="{{ asset('storage/upload/user_images/' . $user->profile_image) }}" alt="Image"
                                    width="100px" height="100px">Storage Folder
                                <img src="{{ url('storage/app/upload/user_images/' . $user->profile_image) }}"
                                    alt="{{ url('storage/app/upload/user_images/' . $user->profile_image) }}">
                            </td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                @can('update', $user)
                                    <a href="{{ route('users.edit-user', $user->id) }}" class="btn btn-warning">Edit User</a>
                                @endcan
                            </td>
                            <td>
                                @can('delete', $user)
                                    <a href="{{ route('users.delete-user', $user->id) }}" class="btn btn-danger">Delete
                                        User</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</div>
