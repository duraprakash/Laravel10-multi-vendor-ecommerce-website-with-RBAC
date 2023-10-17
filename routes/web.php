<?php

use App\Http\Controllers\Api\V1\AdminController;
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
