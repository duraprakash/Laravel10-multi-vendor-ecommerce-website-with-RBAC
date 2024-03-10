<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Create Product</h1>
            <div class="mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-danger">Go Back</a>
            </div>
            <!-- Form to create a new user -->
            <form action="{{ route('products.store-product') }}" method="POST">
                @csrf
                {{-- <div class="form-group">
                    <label for="vendor-id">Vendor ID:</label>
                    <input type="text" class="form-control" id="vendor-id" name="vendor_id" required>
                </div> --}}
                <div class="form-group">
                    <label for="vendor-id">Vendor:</label>
                    <select name="vendor_id" id="vendor-id" class="form-control" required>
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->vendor_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="produc-name">Product Name:</label>
                    <input type="text" class="form-control" id="product-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    {{-- <input type="text" class="form-control" id="price" name="price" required> --}}
                    <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="stock-quantity">Stock Quantity:</label>
                    <input type="number" class="form-control" id="stock-quantity" name="stock_quantity" required>
                </div>
                <div class="form-group">
                    <label for="is-available">Available:</label>
                    {{-- <input type="text" class="form-control" id="is-available" name="is_available" required> --}}
                    <select name="is_available" id="is-available" class="form-control" required>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>

                @can('create', \App\Models\Products::class)
                    {{-- @can('create', $vendor) --}}
                    <div class="mb-4 mt-3">
                        <button type="submit" class="btn btn-primary">Create Product</button>
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
