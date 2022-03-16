<?php

use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EFIController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\OrganizationsController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

// Auth

Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

// Login for Admin
Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// As guest
Route::get('/login', [AuthenticatedSessionController::class, 'loginAsUser'])
    ->name('login.asUser')
    ->middleware('guest');

Route::post('/login', [AuthenticatedSessionController::class, 'storeAsGuest'])
    ->name('login.store.asUser')
    ->middleware('guest');

// Login for ordinary user
Route::delete('/logout', [AuthenticatedSessionController::class, 'logout'])
    ->name('logout.asUser');



// Dashboard

Route::get('/admin', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(['auth', 'admin']);

// Users

Route::get('/admin/users', [UsersController::class, 'index'])
    ->name('users')
    ->middleware('auth');

Route::get('/admin/users/create', [UsersController::class, 'create'])
    ->name('users.create')
    ->middleware('auth');

Route::post('/admin/users', [UsersController::class, 'store'])
    ->name('users.store')
    ->middleware('auth');

Route::get('/admin/users/{user}/edit', [UsersController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth');

Route::put('/admin/users/{user}', [UsersController::class, 'update'])
    ->name('users.update')
    ->middleware('auth');

Route::delete('/admin/users/{user}', [UsersController::class, 'destroy'])
    ->name('users.destroy')
    ->middleware('auth');

Route::put('/admin/users/{user}/restore', [UsersController::class, 'restore'])
    ->name('users.restore')
    ->middleware('auth');

Route::delete('/admin/users/{user}/remove', [UsersController::class, 'remove'])
    ->name('users.remove')
    ->middleware('auth');


// Products

Route::get('/admin/products', [ProductsController::class, 'index'])
    ->name('products')
    ->middleware('auth');

Route::get('/admin/products/create', [ProductsController::class, 'create'])
    ->name('products.create')
    ->middleware('auth');

Route::post('/admin/products', [ProductsController::class, 'store'])
    ->name('products.store')
    ->middleware('auth');

Route::get('/admin/products/{product}/edit', [ProductsController::class, 'edit'])
    ->name('products.edit')
    ->middleware('auth');

Route::put('/admin/products/{product}', [ProductsController::class, 'update'])
    ->name('products.update')
    ->middleware('auth');

Route::delete('/admin/products/{product}', [ProductsController::class, 'destroy'])
    ->name('products.destroy')
    ->middleware('auth');

Route::delete('/admin/products/{product}/remove', [ProductsController::class, 'remove'])
    ->name('products.remove')
    ->middleware('auth');

Route::put('/admin/products/{product}/restore', [ProductsController::class, 'restore'])
    ->name('products.restore')
    ->middleware('auth');


// Organizations

Route::get('/admin/organizations', [OrganizationsController::class, 'index'])
    ->name('organizations')
    ->middleware('auth');

Route::get('/admin/organizations/create', [OrganizationsController::class, 'create'])
    ->name('organizations.create')
    ->middleware('auth');

Route::post('/admin/organizations', [OrganizationsController::class, 'store'])
    ->name('organizations.store')
    ->middleware('auth');

Route::get('/admin/organizations/{organization}/edit', [OrganizationsController::class, 'edit'])
    ->name('organizations.edit')
    ->middleware('auth');

Route::put('/admin/organizations/{organization}', [OrganizationsController::class, 'update'])
    ->name('organizations.update')
    ->middleware('auth');

Route::delete('/admin/organizations/{organization}', [OrganizationsController::class, 'destroy'])
    ->name('organizations.destroy')
    ->middleware('auth');

Route::put('/admin/organizations/{organization}/restore', [OrganizationsController::class, 'restore'])
    ->name('organizations.restore')
    ->middleware('auth');

// Contacts

Route::get('/admin/contacts', [ContactsController::class, 'index'])
    ->name('contacts')
    ->middleware('auth');

Route::get('/admin/contacts/create', [ContactsController::class, 'create'])
    ->name('contacts.create')
    ->middleware('auth');

Route::post('/admin/contacts', [ContactsController::class, 'store'])
    ->name('contacts.store')
    ->middleware('auth');

Route::get('/admin/contacts/{contact}/edit', [ContactsController::class, 'edit'])
    ->name('contacts.edit')
    ->middleware('auth');

Route::put('/admin/contacts/{contact}', [ContactsController::class, 'update'])
    ->name('contacts.update')
    ->middleware('auth');

Route::delete('/admin/contacts/{contact}', [ContactsController::class, 'destroy'])
    ->name('contacts.destroy')
    ->middleware('auth');

Route::put('/admin/contacts/{contact}/restore', [ContactsController::class, 'restore'])
    ->name('contacts.restore')
    ->middleware('auth');

// Reports

Route::get('/admin/reports', [ReportsController::class, 'index'])
    ->name('reports')
    ->middleware('auth');

// Images

Route::get('/img/{path}', [ImagesController::class, 'show'])
    ->where('path', '.*')
    ->name('image');


Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
    Lfm::routes();
});


//? Clients API
Route::get('/primatech/clients', [EFIController::class, 'index'])
    ->name('primatech');

//Route::get('/admin/api/primatech/clients/{vat}', 'EFiscalApiController@show')
//    ->name('primatech.clients.companyByVAT');
