<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.tags', ['tags' => Tag::withTrashed()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Tag::create(['name' => $request->name]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.tags.edit_tag', [
            'tag' => Tag::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tag $tag)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $tag->update($inputs);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json([
            'message' => 'Tag deleted successfully!'
        ]);
    }

    public function remove($id)
    {
        Tag::where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Tag removed successfully!'
        ]);
    }

    public function restore(Tag $tag, $id)
    {
        $tag->whereId($id)->restore();

        return response()->json([
            'message' => 'Tag restored successfully!'
        ]);
    }
}
