<?php
//? Posts
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//? Svako ko je prijavljen moze da vidi svoj profil
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['auth'],
], function () {
    Route::get('/', 'HomeController')->name('admin');
    Route::get('/users/{user}/profile', 'UsersController@profile')->name('user.profile.show');
    Route::put('/users/{user}/profile', 'UsersController@profileUpdate')->name('user.profile.update');

    Route::get('/users/{id}/edit/new-password', 'UsersController@editPassword')
        ->name('users.edit.password');

    Route::put('/users/{id}/edit/new-password/update', 'UsersController@updatePassword')
        ->name('users.update.password');
});


//? Users
Route::group([
    'namespace' => 'Admin',
    'middleware' => ['auth'],
], function () {
    Route::resource('/users', 'UsersController')
        ->name('index', 'users')
        ->name('store', 'users.store')
        ->name('update', 'users.update')
        ->name('destroy', 'user.delete');

    Route::delete('/users/{id}/remove', 'UsersController@remove')->name('users.remove');
    Route::put('/users/{id}/restore', 'UsersController@restore');

    //? Bulk deleting
    Route::delete('/admin/users/delete', 'UsersController@deleteUsers')
        ->name('admin.users.delete');

    Route::delete('/admin/users/remove', 'UsersController@removeUsers')
        ->name('admin.users.remove');

    Route::put('/admin/users/restore', 'UsersController@restoreUsers')
        ->name('admin.users.restore');
});
