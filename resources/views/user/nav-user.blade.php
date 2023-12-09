<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->
    @extends('layouts.app')

    @section('content')
        {{-- <div class="container">
            <h1>Delete User: {{ $user->name }}</h1>
            <p>Are you sure you want to delete this user?</p>
            <!-- Form to delete an existing user -->
            <form action="{{ route('user.delete-user', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete User</button>
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div> --}}
    @endsection

</div>
