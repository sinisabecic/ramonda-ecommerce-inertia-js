<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */

    // Validation request
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
            'first_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'country_id' => 1,
            'account_id' => 1,
        ])
        ->assignRole('User')
        ->photo()->create(['url' => 'default.png']);
    }
}
