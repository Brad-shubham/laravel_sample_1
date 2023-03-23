<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::updateOrCreate([
            'code' => '271'
        ],[
            'name' => 'Kenya',
            'code' => '271'
        ]);
    }
}
