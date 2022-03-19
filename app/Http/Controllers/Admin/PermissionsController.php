<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class PermissionsController extends Controller
{

    public function index()
    {
        return Inertia::render('Permissions/Index', [
            'filters' => Request::all('search'),

            'permissions' => Permission::orderBy('name')
                ->filter(Request::only('search'))
                ->get()
                ->transform(fn ($permission) => [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard_name' => $permission->guard_name,
                    'created_at' => $permission->created_at->diffForHumans(),
                    'updated_at' => $permission->updated_at,
                ]),
        ]);
    }


    public function create()
    {
        return Inertia::render('Permissions/Create');
    }


    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50', Rule::unique('permissions')],
        ]);

        Permission::create(['name' => strtolower(str_replace(' ', '_', Request::get('name')))]);
        return Redirect::route('permissions')->with('success', 'Permission created.');
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
