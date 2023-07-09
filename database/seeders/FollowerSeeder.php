<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Follower;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Follower::factory(10)->create();
    }
}
