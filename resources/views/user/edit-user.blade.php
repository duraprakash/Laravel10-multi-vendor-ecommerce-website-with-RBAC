<div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->

    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Edit User: {{ $user->name }}</h1>
            <!-- Form to edit an existing user -->
            <form action="{{ route('user.update-user', $user->id) }}" method="POST">
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
                {{-- <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="form-text text-muted">Leave blank to keep the current password.</small>
                </div> --}}
                <div class="form-group">
                    <label for="roles">Roles:</label>
                    <select multiple class="form-control" id="roles" name="roles[]" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    @endsection

</div>
