<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Country;
use App\Models\Organization;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $account = Account::create(['name' => 'Ramonda LLC']);
        Country::create(['name' => 'Montenegro', 'short_name' => 'ME']);

               // Create Permissions
        $adminPermissions = [
            'admin_access',
            'permission_create',
            'permission_edit',
            'permission_show',
            'permission_delete',
            'permission_access',
            'user_create',
            'user_edit',
            'user_show',
            'user_delete',
            'user_access',
            'product_create',
            'product_show',
            'product_edit',
            'product_delete',
            'product_access',
            'role_create',
            'role_edit',
            'role_show',
            'role_delete',
            'role_access',
        ];

        // Create Roles
        $role_admin = Role::create(['name' => 'Admin']);
        $role_user = Role::create(['name' => 'User']);

        foreach ($adminPermissions as $permission){
            Permission::create(['name' => $permission]);
            $role_admin->givePermissionTo($permission);
            // $admin->givePermissionTo($permission); // This is for special permissions.
        }

        // Add a user namely admin
        $admin = User::factory()->create([
            'account_id' => 1,
            'first_name' => 'Sinisa',
            'last_name' => 'Becic',
            'username' => 'sinisa',
            'email' => 'sinisa.becic@outlook.com',
            'password' => Hash::make('sinisa94'),
            'country_id' => 1,
        ]);
        $user = User::factory()->create([
            'account_id' => 1,
            'first_name' => 'Ava',
            'last_name' => 'Rodriguez',
            'username' => 'ava',
            'email' => 'ava@ramonda.me',
            'password' => Hash::make('sinisa94'),
            'country_id' => 1,
        ])
        ->photo()->create(['url' => 'default.png']);

        // Assign role admin to user admin
        $admin->assignRole($role_admin->name);
        $user->assignRole($role_user->name);

        User::factory(10)
            ->create(['account_id' => $account->id])
            ->each(function ($user){
                $user->assignRole('User');
            });

//        $organizations = Organization::factory(100)
//            ->create(['account_id' => $account->id]);
//
//        Contact::factory(100)
//            ->create(['account_id' => $account->id])
//            ->each(function ($contact) use ($organizations) {
//                $contact->update(['organization_id' => $organizations->random()->id]);
//            });
    }
}
