<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Follower;
use App\Models\User;

class FollowerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function configure()
    {
        return $this->afterMaking(function (Follower $follower) {
            $user = User::factory()->create();
            $follower_by_user = User::factory()->create();

            $follower->user_id = $user->id;
            $follower->follower_by_user = $follower_by_user->id;
        })->afterCreating(function (Follower $follower) {
            
        });
    }

    public function definition()
    {
        return [
            'is_follow' => $this->faker->boolean,
        ];
    }
}
