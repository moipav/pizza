<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
           'name' => 'Test User',
           'email' => 'test@user.com',
           'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertStatus(201);
    }

    public function test_user_cannot_register_when_empty_name(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email'=> 'test@user.cc',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_user_cannot_register_when_empty_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_password_can_be_confirmed(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@email.co',
            'password' => 'password',
            'password_confirmation' => 'passWord',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_email_can_be_unique(): void
    {
        $user = User::factory()->create();
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
