    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Delete Vendor: {{ $vendor->company_name }}</h1>

            <!-- Form to delete an existing user -->
            <form action="{{ route('vendors.destroy-vendor', $vendor->id) }}" method="post">
                @csrf
                @method('delete')

                <p>Are you sure you want to delete this vendor?</p>

                <div class="mb-4">
                    <a href="{{ route('vendors.index') }}" class="btn btn-success">Go Back</a>
                    <button type="submit" class="btn btn-danger">Delete Vendor</button>
                </div>
            </form>
        </div>
    @endsection
