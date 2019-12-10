<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function createUser()
    {
        $body = [
            'email' => "testmail2@mail.com",
            'password' => 'asdASd123',
            'name' => 'Test Name'
        ];

        $response = $this->postJson('api/register', $body);

        $response->assertOk();
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
        ]);
    }

    /** @test */
    public function login()
    {
        $body = [
            'email' => "testmail@mail.com",
            'password' => 'asdASd123',
        ];

        $response = $this->postJson('api/login', $body);

        $response->assertOk();
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
        ]);
    }
}
