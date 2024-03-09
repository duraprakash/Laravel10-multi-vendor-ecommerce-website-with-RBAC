<h1>hello vendor create form</h1>
Company Name Contact Person Name Description Verification Status

<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Create Vendor</h1>
            <div class="mb-4">
                <a href="{{ route('vendors.index') }}" class="btn btn-danger">Go Back</a>
            </div>
            <!-- Form to create a new user -->
            <form action="{{ route('vendors.store-vendor') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="vendor-name">Vendor Name:</label>
                    <input type="text" class="form-control" id="vendor-name" name="vendor_name" required>
                </div>
                <div class="form-group">
                    <label for="contact-person-name">Contact Person Name:</label>
                    <input type="text" class="form-control" id="contact-person-name" name="contact_person_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="verification-status">Verification Status:</label>
                    <input type="text" class="form-control" id="verification-status" name="verification_status" required>
                </div>

                @can('create', \App\Models\Vendors::class)
                    {{-- @can('create', $vendor) --}}
                    <div class="mb-4 mt-3">
                        <button type="submit" class="btn btn-primary">Create Vendor</button>
                    </div>
                @endcan

            </form>
        </div>
    @endsection
    <style>
        .border-black {
            border: 1px solid black;
            padding: 15px;
        }

        .card-body {
            margin: 0 12px;
        }
    </style>
</div>
