<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function __invoke()
    {
        if (auth()->user()->hasAnyRole(['admin', 'head', 'partner', 'author', 'manager'])) {
            return view('admin.home');
        } else {
            abort(403, 'You are not authorized!');
        }
    }
}
