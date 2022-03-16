<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::resource('/tags', 'TagsController')
    ->name('index', 'blog.tags')
    ->name('store', 'blog.tags.store')
    ->name('edit', 'blog.tags.edit')
    ->name('update', 'blog.tags.update')
    ->name('destroy', 'blog.tags.delete');
Route::put('/tags/{id}/restore', 'TagsController@restore');
Route::delete('/tags/{id}/remove', 'TagsController@remove');

