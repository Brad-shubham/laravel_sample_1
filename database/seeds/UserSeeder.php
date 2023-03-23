<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (app()->environment(['production'])) {
            $users = [
                [
                    'user_data' => [
                        'email' => 'test@user.com',
                        'password' => 'John@12345',
                        'country_code' => 254,
                        'phone_number' => 763555848,
                        'user_type' => \App\Models\User::USER_TYPE['super admin'],
                    ],
                    'user_profile' => [
                        'first_name' => 'John',
                        'surname' => 'Doe',
                        'date_enrolled' => \Illuminate\Support\Facades\Date::now()
                    ],
                ],
                [
                    'user_data' => [
                        'email' => 'test@admin.com',
                        'country_code' => 254,
                        'phone_number' => 1234567890,
                        'user_type' => \App\Models\User::USER_TYPE['admin'],
                    ],
                    'user_profile' => [
                        'first_name' => 'Test',
                        'surname' => 'Admin',
                        'date_enrolled' => \Illuminate\Support\Facades\Date::now()
                    ],
                ],
            ];
        } else {
            $users = [
                [
                    'user_data' => [
                        'email' => 'terst@data.com',
                        'password' => 'John@12345',
                        'country_code' => 254,
                        'phone_number' => 763555848,
                        'user_type' => \App\Models\User::USER_TYPE['super admin'],
                    ],
                    'user_profile' => [
                        'first_name' => 'John',
                        'surname' => 'DOER',
                        'date_enrolled' => \Illuminate\Support\Facades\Date::now()
                    ],
                ],
                [
                    'user_data' => [
                        'email' => 'test@admin+1.com',
                        'country_code' => 254,
                        'phone_number' => 1234567890,
                        'user_type' => \App\Models\User::USER_TYPE['admin'],
                    ],
                    'user_profile' => [
                        'first_name' => 'TEst User',
                        'surname' => 'Admin',
                        'date_enrolled' => \Illuminate\Support\Facades\Date::now()
                    ],
                ],
            ];
        }

        foreach ($users as $user) {
            $user_id = \App\Models\User::updateOrCreate(['email' => $user['user_data']['email']],
                array_merge($user['user_data'], [
                    'password' => (array_key_exists("password",
                        $user['user_data'])) ? bcrypt($user['user_data']['password']) : bcrypt('password@123'),
                    'country_code' => $user['user_data']['country_code'],
                    'phone_number' => $user['user_data']['phone_number'],
                ]));
            \App\Models\UsersProfile::updateOrCreate(['user_id' => $user_id->id], $user['user_profile']);
        }
    }
}
