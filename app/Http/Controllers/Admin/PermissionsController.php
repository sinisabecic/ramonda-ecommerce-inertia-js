<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permissions', ['permissions' => Permission::withTrashed()->get()]);
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
        Permission::create([
            'name' => $request->permission,
            'description' => $request->description,
        ]);
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
        return view('admin.permissions.edit_permission', [
            'permission' => Permission::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Permission $permission)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission)],
            'description' => ['required', 'string', Rule::unique('permissions')->ignore($permission)],
        ]);

        $permission->update($inputs);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json([
            'message' => 'Permission deleted successfully!'
        ]);
    }

    public function remove($id)
    {
        Permission::where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Permission removed successfully!'
        ]);
    }

    public function restore(Permission $permission, $id)
    {
        $permission->whereId($id)->restore();

        return response()->json([
            'message' => 'Permission restored successfully!'
        ]);
    }
}
