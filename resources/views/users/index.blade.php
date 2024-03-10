<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    @extends('layouts.app')
    @section('content')
        <div class="container">
            <h1>User Management</h1>
            @auth
                @php
                    $userRoles = auth()->user()->getRoleNames()->toArray();
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
                                @if (!empty($user->profile_image))
                                    @if (Storage::disk('public')->exists('upload/user_images/' . $user->profile_image))
                                        <img src="{{ asset('storage/upload/user_images/' . $user->profile_image) }}"
                                            alt="{{ $user->name . '\'s profile pic' }}" style="width:100px; height: 100px;">
                                        {{-- <br>Profile img store and found --}}
                                        <br>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info update-profile-btn mt-2"
                                            data-user-id="{{ $user->id }}" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">
                                            Change Profile Pic
                                        </button>
                                    @else
                                        <img src="{{ asset('storage/upload/user_images/' . $user->profile_image) }}"
                                            alt="{{ $user->name . '\'s profile pic' }}"
                                            style="width:100px; height: 100px;">
                                        {{-- <br>Profile img store but not found --}}

                                        <form action="{{ route('users.update-profile', $user->id) }}" method="post"
                                            enctype="multipart/form-data" class="mt-2">
                                            @csrf
                                            @method('PUT')
                                            <label for="profile_image-{{ $user->id }}" class="btn btn-success">Change
                                                Corrupt Pic</label>
                                            <input type="hidden" name="user_id" id="userId">
                                            <input type="file" name="profile_image"
                                                id="profile_image-{{ $user->id }}"><br>
                                            <button type="submit" class="mt-2">Submit</button>
                                        </form>
                                        <style>
                                            #profile_image-{{ $user->id }} {
                                                display: none;
                                            }
                                        </style>
                                    @endif
                                @else
                                    <img src="{{ asset('storage/upload/user_images/default.jpg') }}"
                                        alt="{{ $user->name . '\'s profile pic' }}" style="width:100px; height: 100px;">
                                    {{-- <br>Profile not stored at all --}}
                                    <br>

                                    <!-- Button with Data Attribute -->
                                    <button type="button" class="btn btn-primary mt-2" data-user-id="{{ $user->id }}"
                                        data-bs-toggle="modal" data-bs-target="#updateProfileModal">
                                        Upload Profile Pic
                                    </button>
                                @endif
                            </td>

                            {{-- commented out testing img store at public/storage --}}
                            <td>
                                {{-- @if ($user->profile_image)
                                    <img src="{{ asset('upload/user_images/' . $user->profile_image) }}"
                                        alt="{{ $user->name }}'s Profile Image" class="img-thumbnail" width="80">
                                @else
                                    <p>No profile image available 1st</p>
                                @endif

                                @if ($user->profile_image)
                                    @php
                                        $imagePath = public_path('upload/user_images/' . $user->profile_image);
                                    @endphp

                                    @if (file_exists($imagePath))
                                        <img src="{{ asset('upload/user_images/' . $user->profile_image) }}"
                                            alt="{{ $user->name }}'s Profile Image" class="img-thumbnail" width="80px">
                                    @else
                                        <p>No profile image file found 2nd</p>
                                    @endif
                                @else
                                    <p>No profile image available 3rd</p>
                                @endif
                                Public Folder
                                <p>File Path: {{ public_path('upload/user_images/' . $user->profile_image) }}</p>
                                Storage Folder
                                <p>File Path: {{ asset('storage/upload/user_images/' . $user->profile_image) }}</p>

                                <img id="showImage"
                                    src="{{ !empty($user->profile_image) ? url('upload/user_images/' . $user->profile_image) : url('upload/user_images/default.jpg') }}"
                                    alt="User" style="width:100px; height: 100px;">Public Folder --}}

                                <!-- Assuming $userImage is the UserImage model instance you want to display -->
                                {{-- if doesn't show up then php artisan storage:link  --}}
                                {{-- <img src="{{ asset('storage/upload/user_images/' . $user->profile_image) }}" alt="User Image"
                                    style="width:100px; height: 100px;">Storage Folder --}}
                                {{-- <img src="{{ !empty($user->profile_image) ? asset('storage/upload/user_images/' . $user->profile_image) : asset('storage/upload/user_images/default.jpg') }}"
                                    alt="User" class="img-thumbnail" style="width:100px; height: 100px;"> --}}
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

<!-- Modal for Change profile pic -->
<form action="{{ route('users.update-profile', '') }}" method="post" enctype="multipart/form-data"
    id="updateProfileForm">
    @csrf
    @method('PUT')
    <div class="modal" id="exampleModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalCenterTitle">Change Profile Picture</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Attention!</h4>
                    <p>You are going to change your profile picture.
                        <br>Are you sure?
                    </p>
                    <input type="hidden" name="user_id" id="userId">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- script for modal profile pic changes --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // modal for change profile picture
        var updateProfileForm = document.getElementById('updateProfileForm');
        var userIdInput = document.getElementById('userId');
        showMessage('info', 'Your info message here');   

        // Add event listener to update form action and modal title when the modal is shown
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');

            updateProfileForm.action = "{{ route('users.update-profile', '') }}" + '/' + userId;
            userIdInput.value = userId;
            // document.getElementById('exampleModalCenterTitle').innerText =
            //     'Change Profile Picture' +
            //     userId;
        });

        // modal for upload profile picture/ first profile picture
        var updateProfileFormtry = document.getElementById('updateProfileModalForm');
        var userIdInputtry = document.getElementById('userId');

        $('#updateProfileModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('user-id');

            updateProfileFormtry.action = "{{ route('users.update-profile', '') }}" + '/' + userId;
            userIdInputtry.value = userId;
            // document.getElementById('updateProfileModalTitle').innerText =
            //     'Upload Profile Picture';
        });
    });
</script>

<!-- Modal for Profile pic not upload yet -->
<form action="{{ route('users.update-profile', 1) }}" method="post" enctype="multipart/form-data"
    id="updateProfileModalForm">
    @csrf
    @method('PUT')
    <div class="modal fade" id="updateProfileModal" tabindex="-1" role="dialog"
        aria-labelledby="updateProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileModalTitle">Upload Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Oops!</h4>
                    <p>Seems like you haven't uploaded your profile picture yet.
                        <br>Upload it now.
                    </p>
                    <input type="hidden" name="user_id" id="userId">
                    <input type="file" name="profile_image" id="profile_image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
