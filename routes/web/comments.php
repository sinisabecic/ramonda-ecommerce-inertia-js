<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::resource('/comments', 'CommentsController')
    ->name('index', 'blog.comments');
Route::delete('/comments/{id}/remove', 'CommentsController@remove');

