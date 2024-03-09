<?php

use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VendorController;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/me', [RoleController::class, 'index'])->name('role.index');
// Route::get('/me', function () {
//     // return "Hello how are you?";
// });

// roles
// Route::get('/me', [AdminController::class, 'index'])->name('role.index');
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'createRole'])->name('roles.create-role');
        Route::post('/roles', [RoleController::class, 'storeRole'])->name('roles.store-role');
        Route::get('/roles/{role}/edit', [RoleController::class, 'editRole'])->name('roles.edit-role');
        Route::put('/roles/{role}', [RoleController::class, 'updateRole'])->name('roles.update-role');
        Route::get('/roles/{role}/delete', [RoleController::class, 'deleteRole'])->name('roles.delete-role');
        Route::delete('/roles/{role}', [RoleController::class, 'destroyRole'])->name('roles.destroy-role');
    });
});

// users
// route::method('/url', [ModelController::class, '7CRUD'])->name('folder.blade-file/route');
/**
 *  <form action="{{ route('users.update-user', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
 */
Route::middleware(['auth'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create-user');
        Route::post('/users/register', [UserController::class, 'store'])->name('users.store-user');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit-user');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update-user');
        Route::get('/users/{user}/delete', [UserController::class, 'deleteUser'])->name('users.delete-user');
        Route::delete('/users/{user}', [UserController::class, 'destroyUser'])->name('users.destroy-user');
        // change profile pic only
        // Route::put('/users/{user}/update-profile', [UserController::class, 'uploadProfilePic'])->name('users.update-profile');
        Route::put('/users/profile-pic/{user}', [UserController::class, 'uploadProfilePic'])->name('users.update-profile');
    });
});

// vendors
Route::middleware(['auth'])->group(function () {
    Route::prefix('v1/vendor')->group(function () {
        // Route::get('/vendors', function () {
        //     return 'hello vendor';
        // });
        Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('/vendors/create', [VendorController::class, 'create'])->name('vendors.create-vendor');
        Route::post('/vendors/register', [VendorController::class, 'store'])->name('vendors.store-vendor');
        Route::get('/vendors/{vendor}/edit', [VendorController::class, 'edit'])->name('vendors.edit-vendor');
        Route::put('/vendors/{vendor}', [VendorController::class, 'update'])->name('vendors.update-vendor');
        Route::get('/vendors/{vendor}/delete', [VendorController::class, 'deleteVendor'])->name('vendors.delete-vendor');
        Route::delete('/vendors/{vendor}', [VendorController::class, 'destroyVendor'])->name('vendors.destroy-vendor');
    });
});
// Route::get('/vendors', [VendorController::class, 'index'])->name('vendor.index');
