<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_page_loads(): void
    {
        $response = $this->get('/sign-in');

        $response->assertStatus(200);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->post('/sign-in', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $response = $this->post('/sign-in', [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('message');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_access_education(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/education/dashboard');

        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_education(): void
    {
        $response = $this->get('/education/dashboard');

        $response->assertRedirect('/sign-in');
    }

    public function test_logout_clears_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->post('/logout');

        $this->assertGuest();
    }
}
