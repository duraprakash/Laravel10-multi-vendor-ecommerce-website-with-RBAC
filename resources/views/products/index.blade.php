<div>
    @extends('vendors.vendor_dashboard')

    @section('vendor')
        <div class="container">
            <h1>Product Management</h1>
            @auth
                @php
                    $userRoles = auth()->user()->getRoleNames()->toArray();
                @endphp
                <p>User Role: {{ implode(', ', $userRoles) }}</p>
            @endauth

            <div class="mb-4">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">Go Back</a>
                @can('create', $product)
                    <a href="{{ route('products.create-product') }}" class="btn btn-success">Create New Product</a>
                @endcan
            </div>
            <table class="table">
                <thead>
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Sno.</th>
                        <th>Vendor ID</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                        <th>Available</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    @foreach ($products as $product)
                        <tr>
                            {{-- <td>{{ $user->id }}</td> --}}
                            <td>{{ $count++ }}</td>
                            {{-- <td>{{ $product->vendor_id }}</td> --}}
                            <td>{{ $product->vendor->vendor_name }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>{{ $product->is_available ? 'Yes' : 'No' }}</td>
                            <td>
                                @can('update', $product)
                                    <a href="{{ route('products.edit-product', $product->id) }}" class="btn btn-warning">Edit
                                        Product</a>
                                @endcan
                            </td>
                            <td>
                                @can('delete', $product)
                                    <a href="{{ route('products.delete-product', $product->id) }}"
                                        class="btn btn-danger">Delete
                                        Product</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection

</div>
