<?php

use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\UserController;
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
// Route::get('/me', [AdminController::class, 'index'])->name('admin.index');
// Route::get('/me', function () {
//     // return "Hello how are you?";
// });
// Route::get('/me', [AdminController::class, 'index'])->name('admin.index');
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/roles/create', [AdminController::class, 'createRole'])->name('admin.create-role');
        Route::post('/roles', [AdminController::class, 'storeRole'])->name('admin.store-role');
        Route::get('/roles/{role}/edit', [AdminController::class, 'editRole'])->name('admin.edit-role');
        Route::put('/roles/{role}', [AdminController::class, 'updateRole'])->name('admin.update-role');
        Route::get('/roles/{role}/delete', [AdminController::class, 'deleteRole'])->name('admin.delete-role');
        Route::delete('/roles/{role}', [AdminController::class, 'destroyRole'])->name('admin.destroy-role');
    });
});

// route::method('/url', [ModelController::class, '7CRUD'])->name('folder.blade-file');
Route::middleware(['auth'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create-user');
        Route::post('/users/register', [UserController::class, 'store'])->name('user.store-user');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit-user');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update-user');
        Route::get('/users/{user}/delete', [UserController::class, 'deleteUser'])->name('user.delete-user');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy-user');
    });
});
