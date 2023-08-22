<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_log_in()
    {
        // Contexto o escenario
        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('john1234*'),
        ]);

		// La acción a realizar
        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'john1234*',
        ]);

		// El resultado esperado
        $response->assertStatus(302)
            ->assertRedirect('/dashboard');
        $this->assertTrue(Auth::check());
        $this->assertEquals('John', Auth::user()->name);
        $this->assertTrue(Auth::user()->is($user));
    }

    /** @test */
    public function a_user_cannot_log_in_if_credentials_are_incorrect()
    {
        // Contexto o escenario
        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('john1234*'),
        ]);

        // La acción a realizar
        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'incorrect',
        ]);

        // El resultado esperado
        $response->assertStatus(302);
        $response->assertRedirect('/login');
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function the_email_field_is_required()
    {
        // Contexto o escenario
        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('john1234*'),
        ]);

        // La acción a realizar
        $response = $this->from('/login')->post('/login', [
            'email' => null,
            'password' => 'john1234*',
        ]);

        // El resultado esperado
        $response->assertStatus(302)
            ->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function the_email_field_should_be_a_valid_email()
    {
        // Contexto o escenario
        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('john1234*'),
        ]);

        // La acción a realizar
        $response = $this->from('/login')->post('/login', [
            'email' => 'incorrect-email-format',
            'password' => 'john1234*',
        ]);

        // El resultado esperado
        $response->assertStatus(302)
            ->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse(Auth::check());
    }

    /** @test */
    public function the_password_field_is_required()
    {
        // Contexto o escenario
        $user = User::factory()->create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => bcrypt('john1234*'),
        ]);

        // La acción a realizar
        $response = $this->from('/login')->post('/login', [
            'email' => 'john@example.com',
            'password' => null,
        ]);

        // El resultado esperado
        $response->assertStatus(302)
            ->assertRedirect('/login');
        $response->assertSessionHasErrors('password');
        $this->assertFalse(Auth::check());
    }
}
