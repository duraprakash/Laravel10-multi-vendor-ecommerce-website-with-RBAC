{{-- resources/views/roles/delete-role.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete Role: {{ $role->name }}</h1>

        <form action="{{ route('roles.destroy-role', $role->id) }}" method="post">
            @csrf
            @method('delete')

            <p>Are you sure you want to delete this role?</p>

            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-success">Go Back</a>
                <button type="submit" class="btn btn-danger">Delete Role</button>
            </div>
        </form>
    </div>
@endsection
