<?php

use Illuminate\Database\Seeder;

class PostalCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postalCodes = [
            [
                'zipcode' => 00515,
                'city' => 'BURUBURU',
                'code' => 'KNBURU',
                'full_code' => 'KNBURU - 00515',
            ],
            [
                'zipcode' => 00200,
                'city' => 'CITY SQUARE',
                'code' => 'KNCITY',
                'full_code' => 'KNCITY - 00200',
            ],
            [
                'zipcode' => 00516,
                'city' => 'DANDORA',
                'code' => 'KNDAND',
                'full_code' => 'KNDAND - 00516',
            ],
            [
                'zipcode' => 00610,
                'city' => 'EASTLEIGH',
                'code' => 'KNEAST',
                'full_code' => 'KNEAST - 00610',
            ],
            [
                'zipcode' => 00521,
                'city' => 'EMBAKASI',
                'code' => 'KNEMBA',
                'full_code' => 'KNEMBA - 00521',
            ],
        ];

        foreach ($postalCodes as $postalCode) {
            \App\Models\PostalCode::updateOrCreate([
                'zipcode' => $postalCode['zipcode'],
            ], $postalCode);
        }
    }
}
