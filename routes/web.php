<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenusTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserRolesController;
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
})->middleware(['auth', 'role:Admin', 'verified'])->name('dashboard');


// TODO Admin Route 

Route::middleware(['role:Admin'])->group(function () {
    Route::match(['get', 'post'], 'admin/users/listing', [UserController::class, 'listing'])->name('user_listing');
    Route::match(['get', 'post'], 'admin/users/add', [UserController::class, 'add'])->name('user_add');
    Route::match(['get', 'post'], 'admin/users/edit/{id}', [UserController::class, 'edit'])->name('user_edit');
    Route::post('admin/users/delete', [UserController::class, 'delete'])->name('user_delete');
    Route::match(['get', 'post'], 'admin/profile', [UserController::class, 'admin_profile'])->name('user_profile');

    Route::match(['get', 'post'], 'admin/roles/listing', [UserRolesController::class, 'listing'])->name('user_roles_listing');
    Route::match(['get', 'post'], 'admin/roles/add', [UserRolesController::class, 'add'])->name('user_roles_add');
    Route::match(['get', 'post'], 'admin/roles/edit/{id}', [UserRolesController::class, 'edit'])->name('user_roles_edit');
    Route::match(['get', 'post'], 'admin/roles/delete', [UserRolesController::class, 'delete'])->name('user_roles_delete');

    Route::match(['get', 'post'], 'admin/permission/listing', [UserPermissionController::class, 'listing'])->name('user_permission_listing');
    Route::match(['get', 'post'], 'admin/permission/add', [UserPermissionController::class, 'add'])->name('user_permission_add');
    Route::match(['get', 'post'], 'admin/permission/edit/{id}', [UserPermissionController::class, 'edit'])->name('user_permission_edit');
    Route::match(['get', 'post'], 'admin/permission/delete', [UserPermissionController::class, 'delete'])->name('user_permission_delete');

    Route::match(['get', 'post'], 'admin/user/working-schedule', [UserController::class, 'working_schedule'])->name('working_schedule');
    Route::post('/admin/insert/working_schedule', [UserController::class, 'insert_working_schedule'])->name('insert_working_schedule');

    Route::match(['get', 'post'], 'admin/menus/listing', [MenuController::class, 'listing'])->name('menu_listing');
    Route::match(['get', 'post'], 'admin/menus/add', [MenuController::class, 'add'])->name('menu_add');
    Route::match(['get', 'post'], 'admin/menus/edit/{id}', [MenuController::class, 'edit'])->name('menu_edit');
    Route::match(['get', 'post'], 'admin/menus/delete', [MenuController::class, 'delete'])->name('menu_delete');

    Route::match(['get', 'post'], 'admin/menus_type/listing', [MenusTypeController::class, 'listing'])->name('menu_type_listing');
    Route::match(['get', 'post'], 'admin/menus_type/add', [MenusTypeController::class, 'add'])->name('menu_type_add');
    Route::match(['get', 'post'], 'admin/menus_type/edit/{id}', [MenusTypeController::class, 'edit'])->name('menu_type_edit');
    Route::match(['get', 'post'], 'admin/menus_type/delete', [MenusTypeController::class, 'delete'])->name('menu_type_delete');

});

// TODO User Route
Route::match(['get', 'post'], 'profile', [UserController::class, 'user_profile'])->name('profile')->middleware(['verified']);
// Route::match(['get', 'post'], 'menus')->name('view_menus');


Route::match(['get', 'post'], 'ajax_get_user_roles', [UserController::class, 'search_user_role'])->name('ajax_user_roles');
