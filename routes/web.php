<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('guest.home');
})->name('welcome');

Route::get('admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// TODO Admin Route 

Route::match(['get', 'post'], 'admin/users/listing', [UserController::class, 'listing'])->name('user_listing');
Route::match(['get', 'post'], 'admin/users/add', [UserController::class, 'add'])->name('user_add');
Route::match(['get', 'post'], 'admin/users/edit/{id}', [UserController::class, 'edit'])->name('user_edit');
Route::post('admin/users/delete', [UserController::class, 'delete'])->name('user_delete');
Route::match(['get', 'post'], 'admin/profile', [UserController::class, 'admin_profile'])->name('user_profile');

// TODO User Route
Route::match(['get', 'post'], 'profile', [UserController::class, 'user_profile'])->name('profile');
// Route::match(['get', 'post'], 'menus')->name('view_menus');
