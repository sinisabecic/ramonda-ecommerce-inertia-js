<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
    {
        $pagination = 9;
        $categories = Category::all();

        if (request()->category) {

            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
            $categoryName = optional($categories->where('slug', request()->category)->first())->name;

        } else {
            //All products
            $products = Product::where('featured', true);
            $categoryName = 'Featured';
        }

        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price')->paginate($pagination);

        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc')->paginate($pagination);

        } else {
            $products = $products->paginate($pagination);
        }

        return view('shop')->with([
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ]);
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // Give me all random products (in this case 4 products) which are not included show($slug)
        $mightAlsoLike = Product::where('slug', '!=', $slug)->mightAlsoLike()->get();

        $stockLevel = getStockLevel($product->quantity);

        return view('product')->with([
            'product' => $product,
            'stockLevel' => $stockLevel,
            'mightAlsoLike' => $mightAlsoLike,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|min:3',
        ]);

        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
            ->orWhere('details', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->paginate(10);

//        $products = Product::search($query)->paginate(10);

        return view('search-results')->with('products', $products);
    }

    public function searchAlgolia(Request $request)
    {
        return view('search-results-algolia');
    }
}
