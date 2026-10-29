<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_saves_email_and_normalized_phone(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Mustofa Ali',
            'email' => '  MUSTOFA@example.com ',
            'phone' => '+62 812-3456-7890',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'name' => 'Mustofa Ali',
            'email' => 'mustofa@example.com',
            'phone' => '081234567890',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseCount('users', 1);
    }

    public function test_registration_requires_a_valid_email_and_phone(): void
    {
        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Mustofa Ali',
            'email' => 'not-an-email',
            'phone' => '123',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email', 'phone']);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_rejects_an_existing_email_or_phone(): void
    {
        User::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'role' => User::ROLE_PELANGGAN,
        ]);

        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'phone' => '6281234567890',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors(['email', 'phone']);
        $this->assertDatabaseCount('users', 1);
    }
}
