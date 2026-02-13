<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
//    protected bool $seed = true;

    public function test_users_index(): void
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
    }

    public function test_user_create_page(): void
    {
        $response = $this->get('/users/create');

        $response->assertStatus(200);
        $response->assertViewIs('users.create');//проверяем шаблон
    }



    /**
     * @throws \JsonException
     */
    public function test_user_store(): void
    {
        UserStatus::create(['id'=>'1', 'name' => 'New User']
        );
        $userData = [
            'name' => 'Борис',
            'surname' => 'Бритва',
            'phone' => '1234567890',
            'email' => 'b.razor@sikle.bb',
            'date_of_birth' => '1988-02-24',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $response = $this->post('/users', $userData);
        $response->assertSessionHasNoErrors();
        $response->assertStatus(303);
        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'name' => 'Борис',
            'surname' => 'Бритва',
            'phone' => '1234567890',
            'email' => 'b.razor@sikle.bb',
            'date_of_birth' => '1988-02-24',
        ]);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_show(): void
    {
        $user = User::factory()->create();
        $response = $this->get('/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewHas('user');
        $response->assertViewHas('user', $user);
        $response->assertSee($user->name);

    }

    public function test_user_edit_page(): void
    {
        User::factory(1)->create();
        $user = User::first();
        $response = $this->get('/users/' . $user->id . '/edit');
        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
        $response->assertViewHas('user', $user);
    }

    public function test_user_update(): void
    {
        User::factory(1)->create();
        $user = User::first();

        $updatedData = [
            'name' => 'Борис',
            'surname' => 'Бритва',
            'phone' => '1234567890',
            'email' => 'b.razor@sikle.bb',
            'date_of_birth' => '1988-02-24',
        ] ;

        $response = $this->put('/users/' . $user->id, $updatedData);
        $response->assertStatus(303);
        $response->assertRedirect('/users/' . $user->id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Борис',
            'surname' => 'Бритва',
            'phone' => '1234567890',
            'email' => 'b.razor@sikle.bb',
            'date_of_birth' => '1988-02-24',
        ]);
    }

    public function test_user_destroy(): void
    {
        User::factory(2)->create();
        $user = User::first();
        $this->assertDatabaseCount('users', 2);

        $response = $this->delete('/users/' . $user->id);

        $response->assertStatus(303);
        $response->assertRedirect('/users');
        $response->assertSessionHas('success', 'Пользователь удалён!');
        $this->assertSoftDeleted('users', ['id' => $user->id]);
        //Здесь у нас получается проверить, только на то,что пометили SoftDelete а count у БД все равно 2
        $this->assertDatabaseCount('users', 2);


    }
}
