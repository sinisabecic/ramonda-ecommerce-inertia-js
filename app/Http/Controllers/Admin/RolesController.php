<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class RolesController extends Controller
{

    public function index()
    {
        return Inertia::render('Roles/Index', [
            'filters' => Request::all('search'),

            'roles' => Role::orderBy('name')
                ->filter(Request::only('search'))
                ->get()
                ->transform(fn ($role) => [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                    'created_at' => $role->created_at->diffForHumans(),
                    'updated_at' => $role->updated_at,
                    'permissions' => $role->getAllPermissions(),
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create', [
            'permissions' => Permission::all(),
        ]);
    }


    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50', Rule::unique('roles')],
            'permissions' => ['required'],
        ]);

        $role = Role::create(['name' => Request::get('name')]);
        $role->syncPermissions(Request::input('permissions'));

        return Redirect::route('roles')->with('success', 'Role created.');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        return view('admin.roles.edit_role', [
            'role' => Role::findOrFail($id),
            'permissions' => Permission::all()
        ]);
    }


    public function update(Role $role)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role->permissions()->sync(request()->input('permissions'));
        $role->update($inputs);
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);
    }

    public function remove($id)
    {
        Role::where('id', $id)->forceDelete();
        return response()->json([
            'message' => 'Role removed successfully!'
        ]);
    }

    public function restore(Role $role, $id)
    {
        $role->whereId($id)->restore();

        return response()->json([
            'message' => 'Role restored successfully!'
        ]);
    }
}
