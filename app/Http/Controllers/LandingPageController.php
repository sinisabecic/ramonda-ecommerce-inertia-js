<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        return view('landing-page')->with(
            'products', Product::where('featured', true)->take(8)->inRandomOrder()->get()
        );
    }
}
