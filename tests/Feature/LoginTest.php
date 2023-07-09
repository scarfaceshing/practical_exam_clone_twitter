<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    const FAKE_PASSWORD = '12345';
    const LOGIN_URL = '/api/login';
    const SUCCESS_STATUS = 200;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $password = Hash::make(self::FAKE_PASSWORD);

        $this->user = User::factory()->create([
            'password' => $password
        ]);
    }

    public function test_login_success()
    {
        $response = $this->post(self::LOGIN_URL, [
            'username' => $this->user->username,
            'password' => self::FAKE_PASSWORD
        ]);
        
        $response
            ->assertStatus(self::SUCCESS_STATUS)
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', [
            'username' => $this->user->username,
            'email' => $this->user->email,
            'name' => $this->user->name,
        ]);
    }

    public function test_login_missing_field()
    {
        $response = $this->post(self::LOGIN_URL, [
            'username' => null,
            'password' => null
        ]);

        $errors = session('errors');
        $response->assertSessionHasErrors();
        
        $this->assertEquals($errors->get('username')[0],"The username field is required.");
        $this->assertEquals($errors->get('password')[0],"The password field is required.");
    }

    public function test_login_fail_username()
    {
        $response = $this->post(self::LOGIN_URL, [
            'username' => '!',
            'password' => self::FAKE_PASSWORD
        ]);

        $errors = session('errors');
        $response->assertSessionHasErrors();
        
        $this->assertEquals($errors->get('username')[0],"Username is does'st exist in our database.");
    }
}
