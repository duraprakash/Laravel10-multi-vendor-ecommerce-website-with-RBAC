{{-- resources/views/admin/create-role.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Role</h1>

        <form action="{{ route('admin.store-role') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Role</button>
        </form>
    </div>
@endsection
