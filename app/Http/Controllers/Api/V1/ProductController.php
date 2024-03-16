<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Product\UpdateProductRequest;
use App\Models\Products;
use App\Models\User;
use App\Models\Vendors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Products $product)
    {
        $this->authorize('viewAny', $product);
        $products = Products::all();
        $vendors = Vendors::all();

        // Ensure the authenticated user owns the customer
        // if (Auth::id() !== $user->user_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        return view('products.index', compact('products', 'vendors', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Products $product)
    {
        try {
            $this->authorize('create', $product);
            $vendors = Vendors::all();
            return view('products.create-product', compact('product', 'vendors'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Error creating product'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            /**
             * The VendorResource class is typically used to transform your Eloquent models into a JSON format for API responses.
             *  It's not used for creating or updating records in the database, which is the responsibility of your Eloquent models.
             * 
             * When you create a new record in the database, you should work directly with the Eloquent model. The VendorResource 
             * class comes into play when you want to transform a Vendors model instance into a JSON response for API consumption.
             * 
             * Here's a typical flow:
             * 
             * Code for transforming Vendors model instance into a JSON response for API consumption
             * $newVendor = new VendorResource(Vendors::create($request->all())); // only this line of code 
             * return Redirect::route('vendors.index')->with('success', 'Vendor created successfully');
             * 
             */


            /**
             * Code for working directly with the Eloquent model
             */
            // Check if the authenticated user has the 'create product' permission
            $this->authorize('create', Products::class);

            // Create a new instance of the Vendors model
            $newProduct = new Products($request->all());
            // $newProduct->vendor_id; // = auth()->user()->id; // Associate the vendor with the currently authenticated user
            $newProduct->save();

            return Redirect::route('products.index')->with('success', 'Product created successfully');
        } catch (Exception $e) {
            // return response()->json(['error' => 'Failed to create vendor',  $e], 500);
            return Redirect::route('products.create-product')->with('error', 'Failed to create product');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        $this->authorize('update', $product);

        $user = User::all();
        $vendors = Vendors::all();
        return view('products.edit-product', compact('user', 'product', 'vendors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Products $product)
    {
        try {
            $this->authorize('update', $product);

            // Update the user details
            $product->update($request->validated());


            // Respond with the updated vendor resource
            return Redirect::route('products.index')->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            // Handle any errors during the update
            // return response()->json(['error' => 'Error updating product'], 500);
            return response()->json(['error' => $e], 500);
            // return Redirect::route('products.index')->with('error', 'Failed to update product');
        }
    }

    public function deleteProduct(Products $product)
    {
        $this->authorize('delete', $product);

        return view('products.delete-product', compact('product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyProduct(Products $product)
    {
        try {
            // Delete the vendor
            $product->delete();

            return redirect()->route('products.index')->with('success', 'product deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json(['error' => 'Error deleting product'], 500);
        }
    }
}
