{{-- resources/views/admin/delete-role.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete Role: {{ $role->name }}</h1>

        <form action="{{ route('admin.destroy-role', $role->id) }}" method="post">
            @csrf
            @method('delete')

            <p>Are you sure you want to delete this role?</p>

            <button type="submit" class="btn btn-danger">Delete Role</button>
        </form>
    </div>
@endsection
