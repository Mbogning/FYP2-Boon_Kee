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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// TODO Admin Route 

Route::match(['get', 'post'], 'users/listing', [UserController::class, 'listing'])->name('user_listing');
Route::match(['get', 'post'], 'users/add', [UserController::class, 'add'])->name('user_add');
Route::match(['get', 'post'], 'users/edit/{id}', [UserController::class, 'edit'])->name('user_edit');
Route::post('users/delete', [UserController::class, 'delete'])->name('user_delete');

// TODO User Route
