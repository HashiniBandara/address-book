<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
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

// Default route
// Route::get('/', function () {
//     return view('auth.login');
// });
// Root URL loads the login page
Route::get('/', [PageController::class, 'index'])->name('login');

require __DIR__ . '/auth.php';



// Routes for admin users
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');


    // Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/admin/profile/edit', 'edit')->name('admin.profile.edit');
        Route::patch('/admin/profile', 'update')->name('admin.profile.update');
        // Route::delete('/admin/profile', 'destroy')->name('admin.profile.destroy');
    });

    Route::resource('/admin/customer', CustomerController::class)->names([
        'index' => 'admin.customer.index',
        'create' => 'admin.customer.create',
        'store' => 'admin.customer.store',
        'show' => 'admin.customer.show',
        'edit' => 'admin.customer.edit',
        'update' => 'admin.customer.update',
        'destroy' => 'admin.customer.destroy',
    ]);
    Route::put('/admin/customer/{customer}', [CustomerController::class, 'update'])->name('admin.customer.update');

    Route::post('/admin/customer/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('admin.customer.toggleStatus');

    Route::resource('/admin/project', ProjectController::class)->names([
        'index' => 'admin.project.index',
        'create' => 'admin.project.create',
        'store' => 'admin.project.store',
        'show' => 'admin.project.show',
        'edit' => 'admin.project.edit',
        'update' => 'admin.project.update',
        'destroy' => 'admin.project.destroy',
    ]);
    // Route::get('/admin/project/get-active-customers', [ProjectController::class, 'getActiveCustomers']);
    // Route::post('/admin/project/add-customers', [ProjectController::class, 'addCustomers']);
    // Route::get('/admin/customers/active', [CustomerController::class, 'getActiveCustomers']);
    // Route::post('/admin/project/add-customers', [ProjectController::class, 'addCustomers']);
    Route::get('/admin/customers/active', [CustomerController::class, 'getActiveCustomers']);
    Route::post('/admin/project/add-customers', [ProjectController::class, 'addCustomers']);


    Route::get('/admin/project/searchCustomers', [ProjectController::class, 'searchCustomers'])->name('admin.project.searchCustomers');
    Route::get('/get-customers', [CustomerController::class, 'getCustomers']);
    // Route::get('/admin/project/search-customers', [ProjectController::class, 'searchCustomers'])->name('admin.project.searchCustomers');
    Route::post('/admin/project/{project}/add-customers', [ProjectController::class, 'addCustomers'])->name('admin.project.addCustomers');
    Route::post('/admin/project/{project}/toggle-status', [ProjectController::class, 'toggleStatus'])->name('admin.project.toggle-status');
});


// Routes for regular user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');

    // Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/user/profile/edit', 'edit')->name('user.profile.edit');
        Route::patch('/user/profile', 'update')->name('user.profile.update');
        // Route::delete('/user/profile', 'destroy')->name('user.profile.destroy');
    });
});
