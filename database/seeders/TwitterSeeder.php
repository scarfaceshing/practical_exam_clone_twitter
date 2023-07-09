<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Twitter;

class TwitterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Twitter::factory(10)->create();
    }
}
