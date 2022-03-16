<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Photo;
use App\User;

class PhotosController extends Controller
{
    public function index()
    {
        $users = Photo::all();
        foreach ($users as $user) {
            return $user->imageable;
        }

        return view('admin.media.photos', ['photos' => Photo::all(), 'users' => User::withTrashed()->get()]);
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json([
            'message' => 'Photo deleted successfully!'
        ]);
    }
}
