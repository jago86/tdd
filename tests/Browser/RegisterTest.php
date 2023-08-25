<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_register_a_new_user(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'John Doe')
                    ->type('email', 'john@example.com')
                    ->type('password', 'secret1234')
                    ->type('password_confirmation', 'secret1234')
                    ->press('REGISTER')
                    ->assertPathIs('/dashboard');
        });
    }

    /** @test */
    public function cannot_register_if_name_is_empty(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('email', 'john@example.com')
                ->type('password', 'secret1234')
                ->type('password_confirmation', 'secret1234')
                ->press('REGISTER')
                ->assertPathIs('/register')
                ->assertSee('The name field is required.');
        });
    }
}
