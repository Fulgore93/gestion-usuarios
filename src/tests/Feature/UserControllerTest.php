<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_users_when_authenticated()
    {
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $response = $this->getJson('/api/v1/users');
        
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => User::all()->toArray(),
                    'user_message' => 'Listado de usuarios.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }

    /** @test */
    public function it_cannot_list_users_when_not_authenticated()
    {
        $response = $this->getJson('/api/v1/users');

        $response->assertStatus(401);
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $user = User::factory()->make(['name' => 'Pedro']);

        $response = $this->postJson('/api/v1/register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'passWord12!',
            'password_confirmation' => 'passWord12!',
        ]);
        
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user_message' => 'Usuario registrado correctamente.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }

    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->make(['name' => 'Laura']);

        Sanctum::actingAs($user, ['*']);

        $response = $this->postJson('/api/v1/users', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'passWord123!',
            'password_confirmation' => 'passWord123!',
        ]);
        
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user_message' => 'Usuario creado.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }

    /** @test */
    public function it_can_show_a_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->getJson("/api/v1/users/{$user->id}");

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user_message' => 'Usuario consultado.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->putJson("/api/v1/users/{$user->id}", [
            'name' => 'Juana de Arco',
            'email' => 'juana@test.com',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'juana@test.com',
        ]);
        
        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user_message' => 'Usuario actualizado.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        $response = $this->deleteJson("/api/v1/users/{$user->id}");

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'user_message' => 'Usuario eliminado.',
                    'dev_message' => 'ok'
                ])
                ->assertJsonStructure([
                    'success',
                    'data',
                    'user_message',
                    'dev_message'
                ]);
    }
}