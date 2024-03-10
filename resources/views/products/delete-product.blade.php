    @extends('layouts.app')

    @section('content')
        <div class="container">
            <h1>Delete Product: {{ $product->name }}</h1>

            <!-- Form to delete an existing user -->
            <form action="{{ route('products.destroy-product', $product->id) }}" method="post">
                @csrf
                @method('delete')

                <p>Are you sure you want to delete this product?</p>

                <div class="mb-4">
                    <a href="{{ route('products.index') }}" class="btn btn-success">Go Back</a>
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </div>
            </form>
        </div>
    @endsection
