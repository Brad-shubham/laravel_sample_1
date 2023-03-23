<?php

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
        if (!app()->environment(['production'])) {
            $this->call(CourseSeeder::class);
            $this->call(TestSeeder::class);
            $this->call(PostalCodeSeeder::class);
        }
        $this->call(UserSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(LanguageSeeder::class);
    }
}
