<?php
//? Posts
use App\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

//? Photos (public)
Route::get('/photos', 'PhotosController@index');
Route::put('/photos/profile/{user}/update', 'UsersController@updateProfilePhoto')
    ->name('profile.photo.update');

Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('/media/photos', 'PhotosController')
        ->name('index', 'media.photos')
        ->name('destroy', 'media.photos.destroy');
    Route::put('/photos/{id}/restore', 'PhotosController@restore');
    Route::delete('/photos/{id}/remove', 'PhotosController@remove');


    Route::put('/photos/user/{user}/update', 'UsersController@updatePhoto')
        ->name('user.photo.update');
});

Route::group(['prefix' => 'filemanager', 'middleware' => ['web']], function () {
    Lfm::routes();
});


