<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use League\Flysystem\Exception;
use Throwable;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'filters' => Request::all('search', 'trashed'),
            'categories' => Category::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->get()
                ->transform(fn ($category) => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'created_at' => $category->created_at->diffForHumans(),
                    'deleted_at' => $category->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }


    public function store()
    {
        Category::create([
            'name' => request()->input('name')
        ]);
        return Redirect::route('categories')->with('success', 'Category created.');
    }


    public function edit(Category $category)
    {
        return Inertia::render('Categories/Edit', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
            ],
        ]);
    }


    public function update(Category $category)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($category)],
            'slug' => ['required', Rule::unique('roles')->ignore($category)],
        ]);

        $category->save([
            $category->name = $inputs['name'],
            $category->slug = $inputs['slug'],
        ]);
        return Redirect::route('categories')->with('success', 'Category edited.');
    }


    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        return Redirect::route('categories')->with('success', 'Category deleted.');
    }
}
