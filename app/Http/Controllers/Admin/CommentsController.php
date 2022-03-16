<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function index()
    {
        return view('admin.comments', [
            'posts' => Post::withTrashed()->get()
        ]);
    }


    public function store(Post $post)
    {
        $res = $post->comment(request()->input('comment'));
        if ($res)
            return redirect()->back();
    }


    public function show($id)
    {
        //
    }


    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => 1]);
    }

   
    public function destroy(Comment $comment)
    {
        $comment->delete();
    }
}
