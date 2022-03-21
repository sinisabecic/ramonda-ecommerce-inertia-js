<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Photo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductsController extends Controller
{

    public function index()
    {
        return Inertia::render('Products/Index', [
            'filters' => Request::all('search', 'trashed', 'featured'),
            'products' => Product::withTrashed()
                ->orderByDesc('created_at')
                ->filter(Request::only('search', 'trashed', 'featured'))
                ->get()
                ->transform(fn ($product) => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'details' => $product->details,
                    'description' => $product->description,
                    'featured' => $product->featured,
                    'quantity' => $product->quantity,
                    'price' => $product->presentPrice(),
                    'image' => $product->productImage(),
                    'images' => $product->images,
                    'created_at' => $product->created_at->diffForHumans(),
                    'deleted_at' => $product->deleted_at,
                ]),
        ]);
    }


    public function create()
    {
        return Inertia::render('Products/Create', [
            'categories' => Category::all(),
        ]);
    }


    public function store()
    {
        $product = new Product;

        $inputs = request()->validate([
            'name' => ['required', 'string'],
//            'slug' => '',
            'price' => ['required', 'string'],
            'details' => ['string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048|nullable',
            'images' => '',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048|nullable',
            'featured' => ['required'],
            'quantity' => 'required|numeric|min:1',
        ]);

        // Single image upload
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $image = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Products', request()->file('image'), Str::slug($inputs['name']) . '/' . $image);
            $inputs['image'] = $image;
        }

        // Multiple images uploads
        if (request()->hasFile('images')) {

            foreach (request()->file('images') as $file) {

                $name = $file->getClientOriginalName();
                Storage::putFileAs('files/1/Products', $file, Str::slug($inputs['name']) . '/' . $name);
                $data[] = $name;
            }
            $inputs['images'] = json_encode($data);
        }

        $createdProduct = $product->create($inputs);
        $createdProduct->categories()->sync(request()->categories);

        return Redirect::back()->with('success', 'Product added.');
    }


    public function show($id)
    {
        return view('posts.show', [
            'post' => Product::findOrFail($id),
        ]);
    }


    public function edit(Product $product)
    {
        $other_categories = Category::where('id', '!=', $this->productCategoryId($product))
            ->orderBy('name')
            ->get();

        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'details' => $product->details,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'featured' => $product->featured,
                'deleted_at' => $product->deleted_at,
                'image' => $product->productImage(),
                'images' => $product->images,
                'category_id' => $this->productCategoryId($product),
//                'category_name' => $this->productCategoryName($product),
                'categories' => $product->categories->pluck('name')->toArray(),
            ],
            'other_categories' => $other_categories->pluck('name')->toArray(),
            'all_categories' => Category::pluck('id')->toArray(),
        ]);
    }


    public function productCategoryName($model)
    {
        foreach ($model->categories as $category){
            return $category->name;
        }
    }

    public function productCategoryId($model)
    {
        foreach ($model->categories as $category){
            return $category->pivot->category_id;
        }
    }


    public function update(Product $product)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string'],
//            'slug' => '',
            'price' => ['required', 'string'],
            'details' => ['string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048|nullable',
            'images' => '',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,jfif,svg|max:2048|nullable',
            'featured' => ['required', 'boolean'],
            'quantity' => 'required|numeric|min:1',
        ]);

        // Single images uploads
        if (request()->hasFile('image')) {
            $file = request()->file('image');
            $image = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Products', request()->file('image'), Str::slug($inputs['name']) . '/' . $image);
            $product->update(['image' => $image]);
        }

        // Multiple images uploads
        if (request()->hasFile('images')) {

            foreach (request()->file('images') as $file) {

                $name = $file->getClientOriginalName();
                Storage::putFileAs('files/1/Products', $file, Str::slug($inputs['name']) . '/' . $name);
                $data[] = $name;
            }
            $product->update(['images' => json_encode($data)]);
        }

        $product->save([
            $product->name = $inputs['name'],
            $product->price = $inputs['price'],
            $product->details = $inputs['details'],
            $product->description = $inputs['description'],
            $product->featured = $inputs['featured'],
            $product->quantity = $inputs['quantity'],
        ]);

        request()->validate(['category_id' => 'required']);
        $product->categories()->sync(Request::input('category_id'));

        return Redirect::route('products')->with('success', 'Product edited.');
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return Redirect::back()->with('success', 'Product deleted.');
    }


    public function restore(Product $product)
    {
        $product->restore();
        return Redirect::back()->with('success', 'Product restored.');
    }


    public function remove(Product $product)
    {
        $product->forceDelete();
        return Redirect::route('products')->with('success', 'Product removed.');
    }


    public function deleteProducts(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id', explode(",", $ids))->delete();

    }


    public function removeProducts()
    {
        $ids = request()->ids;
        Product::whereIn("id", explode(",", $ids))->forceDelete();
    }


    public function restoreProducts(Request $request)
    {
        $ids = $request->ids;
        Product::whereIn('id', explode(",", $ids))->restore();
    }
}
