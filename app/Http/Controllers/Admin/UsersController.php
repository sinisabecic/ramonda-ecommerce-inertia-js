<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\User;
//use App\Models\Role;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use function auth;
use function env;
use function request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'filters' => Request::all('search', 'role', 'trashed', 'is_active'),
//            'users' => Auth::orderByName()
                'users' => User::with('photos')
                ->orderByName()
                ->where('id', '!=', auth()->user()->id)
                ->withTrashed()
                ->filter(Request::only('search', 'role', 'trashed', 'is_active'))
                ->get()
                ->transform(fn ($user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role_name' => $this->userRoleName($user),
                    'avatarPath' => env('AVATAR'),
                    'photo' => $user->photos,
                    'deleted_at' => $user->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'countries' => Country::all(),
            'roles' => Role::all(),
        ]);
    }

    public function store()
    {
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'username' => ['required', 'max:50', Rule::unique('users')],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')],
            'password' => ['nullable'],
            'country_id' => ['required'],
            'photo' => ['required', 'image'],
        ]);

       $user = Auth::user()->create([
            'first_name' => Request::get('first_name'),
            'last_name' => Request::get('last_name'),
            'username' => Request::get('username'),
            'email' => Request::get('email'),
            'password' => Hash::make(Request::get('password')),
            'country_id' => Request::get('country_id'),
            'account_id' => 1,
//            'photo_path' => Request::file('photo') ? Request::file('photo')->store('users') : null,
        ]);

        if (request()->hasFile('photo')) {
            $photo = request()->file('photo')->getClientOriginalName();
            Storage::putFileAs('files/1/Avatars', request()->file('photo'), $user->id . '/' . $photo);
            $user->photo()->create(['url' => $photo]);
        } else {
            $user->photo()->create(['url' => 'default.png']);
        }

        return Redirect::route('users')->with('success', 'User created.');
    }

    public function edit(User $user)
    {

        $other_roles = Role::where('id', '!=', $this->userRoleId($user))->get();
        $other_countries = Country::where('id', '!=', $user->country_id)->get();

        return Inertia::render('Users/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'username' => $user->username,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'deleted_at' => $user->deleted_at,
                'country' => $user->country, // for name of country
                'country_id' => $user->country_id,
                'avatarPath' => env('AVATAR'),
                'photo' => $user->photos,
                'role_name' => $this->userRoleName($user),
                'role_id' => $this->userRoleId($user),
            ],
            'other_roles' => $other_roles,
            'countries' => $other_countries,
        ]);
    }

    public function userRoleName($model)
    {
        foreach ($model->roles as $role){
            return $role->name;
        }
    }

    public function userRoleId($model)
    {
        foreach ($model->roles as $role){
            return $role->pivot->role_id;
        }
    }

    public function update(User $user)
    {
        $inputs = request()->validate([
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user)],
            'country_id' => ['nullable'],
        ]);

//        $user->update(Request::only('first_name', 'username', 'last_name', 'email', 'owner', 'country'));

        if (request()->hasFile('photo')) {
            $file = request()->file('photo');
            $photo = $file->getClientOriginalName();
            Storage::putFileAs('files/1/Avatars', request()->file('photo'), $user->id . '/' . $photo);
            $user->photo()->update(['url' => $photo]);
        }

        $user->update($inputs);

        request()->validate([
            'role_name' => ['required', 'string'],
        ]);
        $user->assignRole(request()->input('role_name'));


        if (Request::get('password')) {
            $user->update(['password' => Hash::make(Request::get('password'))]);
        }

        return Redirect::back()->with('success', 'User updated.');
    }


    public function destroy(User $user)
    {
        $user->delete();

        return Redirect::back()->with('success', 'User deleted.');
    }

    public function remove(User $user)
    {
        $user->forceDelete();

        return Redirect::route('users')->with('success', 'User permanently deleted.');
    }


    public function restore(User $user)
    {
        $user->restore();

        return Redirect::back()->with('success', 'User restored.');
    }
}
