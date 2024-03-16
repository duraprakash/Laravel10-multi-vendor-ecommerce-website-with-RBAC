<!-- resources/views/vendor/vendor.blade.php -->

{{-- @extends('vendor.vendor_dashboard')

@section('vendor')
    <div class="container">
        <h1>Welcome, VendorName</h1>

        <p>This is the vendor-specific content for vendorName.</p>

        <-- Add more content specific to the vendor as needed -->

        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
        <div class="mb-4">
            <a href="{{ route('admin.index') }}" class="btn btn-danger">Go Back</a>
            <a href="{{ route('vendor.create-vendor') }}" class="btn btn-success">Create New Vendor</a>
        </div>
        @can('update', $user)
            <a href="{{ route('vendor.edit-vendor', $user->id) }}" class="btn btn-warning">Edit Vendor</a>
        @endcan
        @can('delete', $user)
            <a href="{{ route('vendor.delete-vendor', $user->id) }}" class="btn btn-danger">Delete Vendor</a>
        @endcan
    </div>
@endsection --}}

<div>
    <!-- Smile, breathe, and go slowly. - Thich Nhat Hanh -->

    @extends('vendors.vendor_dashboard')

    @section('vendor')
        <div class="container">
            <h1>Vendor Management</h1>
            @auth
                @php
                    $userRoles = auth()->user()->getRoleNames()->toArray();
                @endphp
                <p>User Role: {{ implode(', ', $userRoles) }}</p>
            @endauth

            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">Go Back</a>
                @can('create', $vendor)
                    <a href="{{ route('vendors.create-vendor') }}" class="btn btn-success">Create New Vendor</a>
                @endcan
            </div>
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Sno.</th>
                        <th>Vendor Name</th>
                        <th>Contact Person Name</th>
                        <th>Description</th>
                        <th>Verification Status</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($vendors as $vendor)
                        <tr>
                            {{-- <td>{{ $user->id }}</td> --}}
                            <td>{{ $count++ }}</td>
                            <td>{{ $vendor->vendor_name }}</td>
                            <td>{{ $vendor->contact_person_name }}</td>
                            <td>{{ $vendor->description }}</td>
                            <td>{{ $vendor->verification_status }}</td>
                            {{-- <td>{{ implode(', ', $vendor->roles->pluck('name')->toArray()) }}</td> --}}
                            <td>
                                @can('update', $vendor)
                                    <a href="{{ route('vendors.edit-vendor', $vendor->id) }}" class="btn btn-warning">Edit
                                        Vendor</a>
                                @endcan
                            </td>
                            <td>
                                @can('delete', $vendor)
                                    <a href="{{ route('vendors.delete-vendor', $vendor->id) }}" class="btn btn-danger">Delete
                                        Vendor</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</div>
