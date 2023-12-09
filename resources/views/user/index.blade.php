<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->

    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>User Management</h1>
            <div class="mb-4">
                <a href="{{ route('admin.index') }}" class="btn btn-danger">Go Back</a>
                <a href="{{ route('user.create-user') }}" class="btn btn-success">Create New User</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                <a href="{{ route('user.edit-user', $user->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('user.delete-user', $user->id) }}" method="POST"
                                    style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                                @can('edit-user', $user)
                                    <a href="{{ route('user.edit-user', $user->id) }}" class="btn btn-primary">Edit</a>
                                @endcan
                                @can('delete-user', $user)
                                    <form action="{{ route('user.delete-user', $user->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</div>
