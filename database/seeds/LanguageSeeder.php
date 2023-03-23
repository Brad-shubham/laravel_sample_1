<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Language::updateOrCreate([
            'slug' => 'EN',
        ], [
            'name' => 'English',
            'slug' => 'EN'
        ]);

        \App\Models\Language::updateOrCreate([
            'slug' => 'ES',
        ], [
            'name' => 'Spanish',
            'slug' => 'ES'
        ]);
    }
}
