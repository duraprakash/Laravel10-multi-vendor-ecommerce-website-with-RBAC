<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Edit Product</h1>
            <div class="mb-4">
                <a href="{{ route('products.index') }}" class="btn btn-danger">Go Back</a>
            </div>
            <!-- Form to update product -->
            <form action="{{ route('products.update-product', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- <div class="form-group">
                    <label for="vendor-id">Vendor ID:</label>
                    <input type="text" class="form-control" id="vendor-id" name="vendor_id"
                        value="{{ $product->vendor_id }}" required>
                </div> --}}
                <div class="form-group">
                    <label for="vendor-id">Vendor Name:</label>
                    <select class="form-control" id="vendor-id" name="vendor_id">
                        @foreach ($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $vendor->id == $product->vendor_id ? 'selected' : '' }}>
                                {{ $vendor->vendor_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="{{ $product->description }}" required>
                </div>
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" class="form-control" id="price" name="price" step="0.01"
                        value="{{ $product->price }}" required>
                </div>
                <div class="form-group">
                    <label for="stock-quantity">Stock Quantity:</label>
                    <input type="number" class="form-control" id="stock-quantity" name="stock_quantity"
                        value="{{ $product->stock_quantity }}" required>
                </div>
                <div class="form-group">
                    <label for="is-available">Available:</label>
                    {{-- <input type="text" class="form-control" id="is-available" name="is_available"
                        value="{{ $product->is_available }}"> --}}
                    <select name="is_available" id="is-available" class="form-control" required>
                        <option value="1" {{ $product->is_available ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ $product->is_available ? '' : 'selected' }}>No</option>
                    </select>
                </div>

                @can('update', \App\Models\Products::class)
                    <div class="mb-4 mt-3">
                        <button type="submit" class="btn btn-primary">Update Product</button>
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
