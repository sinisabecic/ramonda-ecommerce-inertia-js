<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Organization;
use App\Models\User;
use App\Models\Contact;
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

        User::factory()->create([
            'account_id' => 1,
            'first_name' => 'Sinisa',
            'last_name' => 'Becic',
            'username' => 'sinisa',
            'email' => 'sinisa.becic@outlook.com',
            'password' => 'sinisa94',
            'owner' => true,
            'country_id' => 248,
        ]);

        User::factory(5)->create(['account_id' => $account->id]);

        $organizations = Organization::factory(100)
            ->create(['account_id' => $account->id]);

        Contact::factory(100)
            ->create(['account_id' => $account->id])
            ->each(function ($contact) use ($organizations) {
                $contact->update(['organization_id' => $organizations->random()->id]);
            });
    }
}
