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
            'permissions' => Permission::pluck('name')->toArray(),
        ]);
    }


    public function store()
    {
        Request::validate([
            'name' => ['required', 'max:50', Rule::unique('roles')],
            'permissions' => ['required'],
        ]);

        $role = Role::create(['name' => str_replace(' ', '', Request::get('name'))]);
        $role->syncPermissions(Request::input('permissions'));

        return Redirect::route('roles')->with('success', 'Role created.');
    }


    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
                'permissions' => $role->permissions->pluck('name'),
            ],
            'all_permissions' => Permission::pluck('name')->toArray(),
        ]);
    }


    public function update(Role $role)
    {
        $inputs = request()->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role->update($inputs);
        $role->syncPermissions(Request::input('permissions'));

        return Redirect::route('roles')->with('success', 'Role edited.');
    }


    public function destroy(Role $role)
    {
        $role->delete();
        return Redirect::route('roles')->with('success', 'Role deleted.');
    }
}
