<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{

    public function index()
    {
        return view('admin.roles')->with([
            'roles' => Role::withTrashed()->get(),
            'permissions' => Permission::all()
        ]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->role,
        ]);

        $role->permissions()->attach($request->permissions);
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
