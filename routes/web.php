<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenusTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('guest.home');
})->name('welcome');

Route::get('admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'role:Admin|Chef|Cashier|Waiter', 'verified'])->name('dashboard');


// TODO Admin Route 

Route::middleware(['role:Admin|Chef|Cashier|Waiter'])->group(function () {

    // TODO ADMIN
    Route::middleware('role:Admin')->group(function () {

        // ? User Manage
        Route::match(['get', 'post'], 'admin/users/listing', [UserController::class, 'listing'])->name('user_listing');
        Route::match(['get', 'post'], 'admin/users/add', [UserController::class, 'add'])->name('user_add');
        Route::match(['get', 'post'], 'admin/users/edit/{id}', [UserController::class, 'edit'])->name('user_edit');
        Route::post('admin/users/delete', [UserController::class, 'delete'])->name('user_delete');

        Route::match(['get', 'post'], 'admin/roles/listing', [UserRolesController::class, 'listing'])->name('user_roles_listing');
        Route::match(['get', 'post'], 'admin/roles/add', [UserRolesController::class, 'add'])->name('user_roles_add');
        Route::match(['get', 'post'], 'admin/roles/edit/{id}', [UserRolesController::class, 'edit'])->name('user_roles_edit');
        Route::match(['get', 'post'], 'admin/roles/delete', [UserRolesController::class, 'delete'])->name('user_roles_delete');

        Route::match(['get', 'post'], 'admin/permission/listing', [UserPermissionController::class, 'listing'])->name('user_permission_listing');
        Route::match(['get', 'post'], 'admin/permission/add', [UserPermissionController::class, 'add'])->name('user_permission_add');
        Route::match(['get', 'post'], 'admin/permission/edit/{id}', [UserPermissionController::class, 'edit'])->name('user_permission_edit');
        Route::match(['get', 'post'], 'admin/permission/delete', [UserPermissionController::class, 'delete'])->name('user_permission_delete');

        // ? Work Schedule
        Route::match(['get', 'post'], 'admin/user/working-schedule', [UserController::class, 'working_schedule'])->name('working_schedule');
        Route::post('/admin/insert/working_schedule', [UserController::class, 'insert_working_schedule'])->name('insert_working_schedule');

        // ? Menu Manage
        Route::match(['get', 'post'], 'admin/menus/listing', [MenuController::class, 'listing'])->name('menu_listing');
        Route::match(['get', 'post'], 'admin/menus/add', [MenuController::class, 'add'])->name('menu_add');
        Route::match(['get', 'post'], 'admin/menus/edit/{id}', [MenuController::class, 'edit'])->name('menu_edit');
        Route::match(['get', 'post'], 'admin/menus/delete', [MenuController::class, 'delete'])->name('menu_delete');

        Route::match(['get', 'post'], 'admin/menus_type/listing', [MenusTypeController::class, 'listing'])->name('menu_type_listing');
        Route::match(['get', 'post'], 'admin/menus_type/add', [MenusTypeController::class, 'add'])->name('menu_type_add');
        Route::match(['get', 'post'], 'admin/menus_type/edit/{id}', [MenusTypeController::class, 'edit'])->name('menu_type_edit');
        Route::match(['get', 'post'], 'admin/menus_type/delete', [MenusTypeController::class, 'delete'])->name('menu_type_delete');

        // ? Reservation
        Route::match(['get', 'post'], 'admin/reservation/add', [ReservationController::class, 'add'])->name('reservation_add');
        Route::match(['get', 'post'], 'admin/reservation/edit/{id}', [ReservationController::class, 'edit'])->name('reservation_edit');
        Route::match(['get', 'post'], 'admin/reservation/delete', [ReservationController::class, 'delete'])->name('reservation_delete');
    });

    // TODO ALL Roles except Customer 
    Route::match(['get', 'post'], 'admin/profile', [UserController::class, 'admin_profile'])->name('user_profile');
    Route::match(['get', 'post'], 'admin/work-schedule', [WorkScheduleController::class, 'view_schedule'])->name('view_working_schedule');

    // TODO Reservation
    Route::match(['get', 'post'], 'admin/reservation/listing', [ReservationController::class, 'listing'])->name('reservation_listing');

    // TODO Chef or Waiter
    Route::middleware('role:Waiter|Chef')->group(function () {
        Route::match(['get', 'post'], 'admin/reservation/update/{id}', [ReservationController::class, 'update_status'])->name('reservation_update');
    });

    Route::middleware('role:Cashier')->group(function () {
        Route::match(['get', 'post'], 'admin/reservation/payment/{id}', [ReservationController::class, 'reservation_payment'])->name('reservation_payment');
    });
});

// TODO User Route
Route::match(['get', 'post'], 'profile', [UserController::class, 'user_profile'])->name('profile')->middleware(['auth', 'verified']);
Route::match(['get', 'post'], 'menus', [MenuController::class, 'view_menus'])->name('view_menus');
Route::match(['get', 'post'], 'menus/{slug}', [MenuController::class, 'view_menu_info'])->name('view_menu_info');
Route::match(['get', 'post'], 'about-us', [CustomerController::class, 'about_us'])->name('about_us');
Route::match(['get', 'post'], 'cart', [CustomerController::class, 'cart'])->name('cart')->middleware(['auth', 'verified']);


// TODO AJAX Call
Route::match(['get', 'post'], 'ajax_get_user_roles', [UserController::class, 'search_user_role'])->name('ajax_user_roles');
Route::match(['get', 'post'], 'ajax_get_active_customer', [UserController::class, 'ajax_get_customer'])->name('ajax_get_customer');
Route::match(['get', 'post'], 'ajax_get_menus', [MenuController::class, 'ajax_get_menu'])->name('ajax_get_menu');
Route::match(['get', 'post'], 'ajax_get_menu_details', [MenuController::class, 'ajax_get_menu_details'])->name('ajax_get_menu_details');
Route::match(['get', 'post'], 'ajax_add_to_cart', [ReservationController::class, 'ajax_add_to_cart'])->name('ajax_add_to_cart');
Route::match(['get', 'post'], 'ajax_update_cart', [ReservationController::class, 'ajax_update_cart'])->name('ajax_update_cart');
