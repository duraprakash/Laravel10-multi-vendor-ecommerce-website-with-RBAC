<!-- resources/views/errors/403.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-md-8">
                <div class="jumbotron text-center">
                    <h1>403 - Forbidden</h1>
                    <p>Sorry, you don't have permission to access this page.</p>
                    <a href="{{ route('home') }}" class="btn btn-danger">Return Home</a>
                    <a href="{{ URL::previous() }}" class="btn btn-success">Go Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
