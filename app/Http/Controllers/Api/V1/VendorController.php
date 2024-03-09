<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Vendor\DeleteVendorRequest;
use App\Http\Requests\V1\Vendor\UpdateVendorRequest;
use App\Http\Resources\V1\Vendor\VendorResource;
use App\Models\User;
use App\Models\Vendors;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Vendors $vendor)
    {
        $this->authorize('viewAny', $vendor);
        $vendors = Vendors::all();

        // Ensure the authenticated user owns the customer
        // if (Auth::id() !== $user->user_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Vendors $vendor)
    {
        try {
            $this->authorize('create', $vendor);
            // return redirect()->route('vendors.create-vendor')->with('success', 'Taking you to create form.');
            return view('vendors.create-vendor', $vendor);
        } catch (Exception $e) {
            return response()->json(['error' => 'Error creating user'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Role $role)
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
            // Check if the authenticated user has the 'create vendor' permission
            $this->authorize('create', Vendors::class);

            // Create a new instance of the Vendors model
            $newVendor = new Vendors($request->all());
            $newVendor->user_id = auth()->user()->id; // Associate the vendor with the currently authenticated user
            $newVendor->save();

            return Redirect::route('vendors.index')->with('success', 'Vendor created successfully');
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create vendor',  $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vendors $vendor)
    {
        return new VendorResource($vendor);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendors $vendor)
    {
        $this->authorize('update', $vendor);

        $user = User::all();
        return view('vendors.edit-vendor', compact('user', 'vendor'));
        // return view('users.edit-user', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendors $vendor)
    {
        // return 'vendor update';

        try {
            $this->authorize('update', $vendor);

            // Update the user details
            $vendor->update($request->validated());


            // Respond with the updated vendor resource
            return Redirect::route('vendors.index')->with('success', 'Vendor updated successfully');
        } catch (\Exception $e) {
            // Handle any errors during the update
            return response()->json(['error' => 'Error updating vendor'], 500);
        }
    }


    public function deleteVendor(Vendors $vendor)
    {
        $this->authorize('delete', $vendor);

        return view('vendors.delete-vendor', compact('vendor'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyVendor(DeleteVendorRequest $request, Vendors $vendor)
    {
        try {
            // Delete the vendor
            $vendor->delete();

            return redirect()->route('vendors.index')->with('success', 'vendor deleted successfully.');
        } catch (\Exception $e) {
            // Handle any errors during deletion
            return response()->json(['error' => 'Error deleting vendor'], 500);
        }
    }
}
