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
                        {{-- <th>ID</th> --}}
                        <th>Sno.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
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
                            <td>{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                            <td>
                                @can('update', $user)
                                    <a href="{{ route('user.edit-user', $user->id) }}" class="btn btn-warning">Edit User</a>
                                @endcan
                                @can('delete', $user)
                                    <a href="{{ route('user.delete-user', $user->id) }}" class="btn btn-danger">Delete User</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</div>
