<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    const FAKE_PASSWORD = '12345';
    const REGISTER_URL = '/api/register';
    const SUCCESS_STATUS = 200;

    private $params;

    public function setUp(): void
    {
        parent::setUp();

        $faker = Faker::create();

        $username = str_replace('.', '', $faker->username);
        $name = $faker->firstName . " " . $faker->lastName;

        $this->params = [
            'username' => $username,
            'password' => $faker->password,
            'name' => $name,
            'email' => $faker->email
        ];
    }

    public function test_register()
    {
        $response = $this->post(self::REGISTER_URL, $this->params);
    
        $response->assertStatus(self::SUCCESS_STATUS)
            ->assertJson([
                'message' => 'Register Successfully',
            ]);

        $params = $this->params;
        
        $this->assertDatabaseHas('users', [
            'username' => $this->params['username'],
            'name' => $this->params['name'],
            'email' => $this->params['email']
        ]);
    }

    public function test_register_fail()
    {
        $response = $this->post(self::REGISTER_URL, []);

        $errors = session('errors');
        $response->assertSessionHasErrors();
    }
}
