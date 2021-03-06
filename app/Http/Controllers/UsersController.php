<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    public function edit()
    {
        return view('my-profile')->with(
            [
                'user' => auth()->user(),
                'countries' => Country::all()
            ]);
    }


    public function update(Request $request)
    {
        $inputs = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id(),
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'country_id' => 'required',
        ]);

        $user = auth()->user();

        if (!$request->get('password') && !$request->get('password_confirmation') ) {

            $user->update($inputs);
            return Redirect::back()->with('success_message', 'Profile updated successfully!');
        }

//        $input = $request->except('password', 'password_confirmation'); ne radi
        // If password not inputed in field, update user
//        if (! $request->filled('password')) {
////            $user->fill($input)->save(); ne radi
//
//            return Redirect::back()->with('success_message', 'Profile updated successfully!');
//        }

//        $user->password = Hash::make($request->password);
        $user->update(['password' => Hash::make(Request::get('password'))]);
        $user->update($inputs);
//        $user->fill($input)->save();

        return Redirect::back()->with('success_message', 'Profile (and password) updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
