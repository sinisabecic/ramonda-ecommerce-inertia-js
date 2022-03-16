<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//? Products
Route::group([
    'middleware' => ['auth', 'admin'],
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {

    Route::resource('/products', 'ProductsController')
        ->name('index', 'products')
        ->name('create', 'products.create')
        ->name('store', 'products.store')
        ->name('edit', 'products.edit')
        ->name('update', 'products.update')
        ->name('destroy', 'products.destroy');


    Route::delete('/products/{id}', 'ProductsController@destroy')
        ->name('products.destroy');

    Route::put('/products/{id}/restore', 'ProductsController@restore')
        ->name('products.restore');
    Route::delete('/products/{id}/remove', 'ProductsController@remove')
        ->name('products.remove');

    // Bulk
    Route::post('/products/delete', 'ProductsController@deleteProducts')
        ->name('products.delete');

    Route::post('/products/remove', 'ProductsController@removeProducts')
        ->name('products.remove');

    Route::post('/products/restore', 'ProductsController@restoreProducts')
        ->name('products.restore');
});