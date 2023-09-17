<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TransfersTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_see_validation_error_messages_when_form_is_empty(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('message', 'as')
                    ->press('Enviar')
                    ->assertSee('The to email field is required.')
                    ->assertSee('The from email field is required.')
                    ->assertSee('The title field is required.')
                    ->assertSee('The file field is required.')
                    ->assertSee('The message field must be at least 5 characters.');
        });
    }

    /** @test */
    public function can_see_a_success_message()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->type('from_email', 'john@example.com')
                    ->type('to_email', 'susan@example.com')
                    ->type('title', 'Fotografías')
                    ->type('message', 'Aquí están las fotografías.')
                    ->attach('file', base_path('tests/__fixtures__/images.zip'))
                    ->press('Enviar')
                    ->assertSee('Tus archivos se enviaron correctamente.');
        });
    }
}
