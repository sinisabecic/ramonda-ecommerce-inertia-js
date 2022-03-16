<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Throwable;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('admin.categories')->with(['categories' => Category::withTrashed()->get()]);
    }

    public function create()
    {
        //
    }

    public function store()
    {
        Category::create([
            'name' => request()->input('category')
        ]);
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return view('admin.categories.edit_category', [
            'category' => Category::findOrFail($id),
        ]);
    }


    public function update(Category $category)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string'],
        ]);

        $category->save([
            $category->name = $inputs['name'],
            $category->slug = $inputs['slug'],
        ]);
//        $category->update($inputs);
    }


    public function destroy($id)
    {
        Category::where('id', $id)->delete();
    }


    public function remove($id)
    {
        Category::where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Category removed successfully!'
        ]);
    }


    public function restore(Category $category, $id)
    {
        $category->whereId($id)->restore();

        return response()->json([
            'message' => 'Category restored successfully!'
        ]);
    }

    public function deleteCategories(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', explode(",", $ids))->delete();

    }


    public function removeCategories()
    {
        $ids = request()->ids;
        Category::whereIn("id", explode(",", $ids))->forceDelete();
    }


    public function restoreCategories(Request $request)
    {
        $ids = $request->ids;
        Category::whereIn('id', explode(",", $ids))->restore();
    }
}
