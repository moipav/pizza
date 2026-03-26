<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
use refreshDatabase, WithFaker;
public User $user;
    public function test_show_login_form(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_authenticated_user_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@mail.ru',
            'password' => 'password123'
        ]);
        $this->assertAuthenticatedAs($this->user);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_authenticated_user_with_invalid_credentials(): void
    {
        $response = $this->post('/login', [
            'email' => 'invalid@test.qq',
            'password' => 'invalidpasswor123'
        ]);

        $this->assertGuest();
        $response->assertStatus(401);
        $response->assertSessionHasErrors('email');
    }

    public function test_login_and_remember(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@mail.ru',
            'password' => 'password123',
            'remember' => true
        ]);

        $this->assertAuthenticatedAs($this->user);
        $response->assertRedirect(route('home'));
    }

    public function test_logout(): void
    {
        $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password123',
        ]);
        $this->actingAs($this->user);

        $response = $this->post('/logout');

        $response->assertRedirect(route('home'));
        $this->assertGuest();

    }


    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(
            [
                'email' => 'test@mail.ru',
                'password' => bcrypt('password123')
            ]
        );

    }
}
