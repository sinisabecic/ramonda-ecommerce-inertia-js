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


    public function edit(Permission $permission)
    {
        return Inertia::render('Permissions/Edit', [
            'permission' => [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
            ],
        ]);
    }


    public function update(Permission $permission)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'min:1', 'max:255', Rule::unique('permissions')->ignore($permission)],
        ]);

        $permission->update($inputs);
        return Redirect::route('permissions')->with('success', 'Permission edited.');

    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        return Redirect::route('permissions')->with('success', 'Permission deleted.');
//        return response()->json([
//            'message' => 'Permission deleted successfully!'
//        ]);
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
