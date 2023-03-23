<?php

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\UsersProfile;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run this seed individually by changing values to create a new superadmin user.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate([
            'email' => 'test@test.com',
            'password' => bcrypt('Kevin@12345'),
            'country_code' => 254,
            'phone_number' => null,
            'user_type' => User::USER_TYPE['super admin'],
        ]);
        UsersProfile::updateOrCreate([
            'user_id' => $user->id,
            'first_name' => 'TEst',
            'surname' => 'User',
            'date_enrolled' => \Illuminate\Support\Facades\Date::now()
        ]);
    }
}
