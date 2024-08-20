<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_register_a_user()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success', 'Registration successful! You can now log in.');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function it_cannot_register_a_user_with_invalid_data()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
        ]);

        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
        ]);
    }

    /** @test */
    public function it_can_login_a_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'), 
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success', 'Login successful!');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function it_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors([
            'login',
        ]);
        $this->assertGuest();
    }

    /** @test */
    public function it_can_logout_a_user()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertRedirect('/login');

    $response->assertSessionHas('success', 'You have been logged out successfully.');

    $this->assertGuest();
}
}
