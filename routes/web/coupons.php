<?php

use App\Http\Controllers\Admin\CouponsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//? Coupons(admin)
Route::group([
    'middleware' => ['auth', 'admin'],
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {
    Route::resource('/admin/products/coupons', CouponsController::class)
        ->name('index', 'products.coupons') // admin.products.coupons
        ->name('edit', 'products.coupons.edit')
        ->name('update', 'products.coupons.update')
        ->name('destroy', 'products.coupons.destroy');


    Route::post('/admin/products/coupons/addPercentDiscount', [CouponsController::class, 'addPercentDiscount'])
        ->name('products.coupons.addPercentDiscount');

    Route::post('/admin/products/coupons/addFixedDiscount', [CouponsController::class, 'addFixedDiscount'])
        ->name('products.coupons.addFixedDiscount');


    //? Bulk
    Route::post('/admin/products/coupons/deleteCoupons', 'CouponsController@deleteCoupons')
        ->name('products.coupons.deleteCoupons');
});