<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class FollowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    const SUCCESS_STATUS = 200;

    private $user;
    private $idol;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->idol = User::factory()->create();

        $token = $this->user->createToken('API TOKEN')->accessToken;

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);
    }

    public function test_follow()
    {
        $this->actingAs($this->user)
            ->get(route('follow', ['username' => $this->idol->username]))
            ->assertStatus(self::SUCCESS_STATUS);
    }

    public function test_unfollow()
    {
        $this->actingAs($this->user)
            ->get(route('un_follow', ['username' => $this->idol->username]))
            ->assertStatus(self::SUCCESS_STATUS);
    }
}
