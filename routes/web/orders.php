<?php

use App\Http\Controllers\Admin\OrdersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth', 'admin'],
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {

    Route::get('/admin/products/orders', [OrdersController::class, 'index'])
        ->name('admin.products.orders');

    Route::get('/admin/products/orders/{order}', [OrdersController::class, 'show'])
        ->name('admin.products.orders.show');

    Route::put('/admin/products/orders/{order}/updateOrder', [OrdersController::class, 'updateOrder'])
        ->name('admin.products.orders.updateOrder');

    Route::put('/admin/products/orders/{order}/shipOrder', [OrdersController::class, 'shipOrder'])
        ->name('admin.products.orders.shipOrder');

    //? Bulk
    Route::post('/admin/products/orders/shipOrders', [OrdersController::class, 'shipOrders'])
        ->name('admin.products.orders.shipOrders');
    Route::post('/admin/products/orders/deleteOrders', [OrdersController::class, 'deleteOrders'])
        ->name('admin.products.orders.deleteOrders');

});