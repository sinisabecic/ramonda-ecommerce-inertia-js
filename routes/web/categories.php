<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Products categories
Route::group([
    'middleware' => ['auth', 'admin'],
    'namespace' => 'Admin',
    'as' => 'admin.'
], function () {

    Route::resource('/products/categories', 'CategoriesController')
        ->name('index', 'products.categories') // admin.products.categories
        ->name('store', 'products.categories.store')
        ->name('edit', 'products.categories.edit')
        ->name('update', 'products.categories.update')
        ->name('destroy', 'products.categories.destroy');

    //Restore user
    Route::put('/products/categories/{id}/restore', 'CategoriesController@restore');

    //Remove user
    Route::delete('/products/categories/{id}/remove', 'CategoriesController@remove');

    // Bulk
    Route::post('/products/categories/delete', 'CategoriesController@deleteCategories')
        ->name('products.categories.delete');

    Route::post('/products/categories/remove', 'CategoriesController@removeCategories')
        ->name('products.categories.remove');

    Route::post('/products/categories/restore', 'CategoriesController@restoreCategories')
        ->name('products.categories.restore');

});