<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Twitter;
use App\Models\Follower;
use App\Models\User;

class TwitterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function configure()
    {
        return $this->afterMaking(function (Twitter $twitter) {
            $follower = Follower::factory()->create();

            $twitter->tweet_by_user = $follower->user_id;
        })->afterCreating(function (Twitter $twitter) {
            
        });
    }

    public function definition()
    {
        return [
            'tweet' => $this->faker->sentence,
            'file_name' => Str::random(40) . '.jpg'
        ];
    }
}
