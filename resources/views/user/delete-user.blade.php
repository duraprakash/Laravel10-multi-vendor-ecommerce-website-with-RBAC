    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Delete User: {{ $user->name }}</h1>

            <!-- Form to delete an existing user -->
            <form action="{{ route('user.destroy-user', $user->id) }}" method="post">
                @csrf
                @method('delete')

                <p>Are you sure you want to delete this user?</p>

                <div class="mb-4">
                    <a href="{{ route('user.index') }}" class="btn btn-success">Go Back</a>
                    <button type="submit" class="btn btn-danger">Delete Role</button>
                </div>
            </form>
        </div>
    @endsection
