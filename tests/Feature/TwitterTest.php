<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Twitter;
use Faker\Factory as Faker;

class TwitterTest extends TestCase
{
    const LOGIN_URL = '/api/login';
    const TWITTER_URL = '/api/v1/twitter';
    const SUCCESS_STATUS = 200;
    const FAKE_PASSWORD = '12345';

    private $user;
    private $faker;
    private $file;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $password = Hash::make(self::FAKE_PASSWORD);

        $this->user = User::factory()->create();
        $token = $this->user->createToken('API TOKEN')->accessToken;

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ]);

        Storage::fake('avatars');
        $this->file = UploadedFile::fake()->image('avatar.jpg');
    }

    public function test_twitter_index()
    {
        $twitter = Twitter::factory(10)->create();

        $this->actingAs($this->user)
            ->get(route('twitter.index'))
            ->assertStatus(self::SUCCESS_STATUS);
    }

    public function test_twitter_show()
    {
        $twitter = Twitter::factory()->create();

        $this->actingAs($this->user)
            ->get(route('twitter.show', ['twitter' => $twitter->id]))
            ->assertStatus(self::SUCCESS_STATUS);

        $this->assertDatabaseHas('twitters', [
            'tweet' => $twitter->tweet,
            'file_name' => $twitter->file_name
        ]);
    }

    public function test_twitter_store()
    {
        $tweet = $this->faker->sentence;

        $params = [
            'tweet' => $tweet,
            'file' => $this->file
        ];

        $this->actingAs($this->user)
            ->post(route('twitter.store'), $params)
            ->assertStatus(self::SUCCESS_STATUS);

        $file_name = time() . '_avatar.jpg';

        $this->assertDatabaseHas('twitters', [
            'tweet' => $tweet,
            'file_name' => $file_name
        ]);

        Storage::disk('twitter')->assertExists($file_name);
    }

    public function test_twitter_update()
    {        
        $twitter = Twitter::factory()->create();
        $tweet = $this->faker->sentence;
        $file = $this->file;

        $params = [
            'tweet' => $tweet,
            'file' => $file,
            '_method' => 'post'
        ];
        
        $response = $this->actingAs($this->user)
            ->put(route('twitter.update', ['twitter' => $twitter->id]), $params)
            ->assertStatus(self::SUCCESS_STATUS);

        $file_name = time() . '_' . $file->name;

        $this->assertDatabaseHas('twitters', [
            'id' => $twitter->id,
            'tweet' => $tweet,
            'file_name' => $file_name
        ]);

        Storage::disk('twitter')->assertExists($file_name);
    }

    public function test_twitter_delete()
    {        
        $twitter = Twitter::factory()->create();
        
        $response = $this->actingAs($this->user)
            ->delete(route('twitter.destroy', ['twitter' => $twitter->id]))
            ->assertStatus(self::SUCCESS_STATUS);

        $file_name = time() . '_' . $twitter->file_name;

        $this->assertDatabaseMissing('twitters', [
            'id' => $twitter->id,
            'tweet' => $twitter->tweet,
            'file_name' => $twitter->file_name
        ]);

        Storage::disk('twitter')->assertMissing($file_name);
    }
}
