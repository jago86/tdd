<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    /** @test */
    public function can_show_home_page()
    {
        // Contexto o escenario
        $url = '/';

		// La acción a realizar
        $response = $this->get($url);

		// El resultado esperado
        $response->assertStatus(200);
        $response->assertSee('Enviar Archivos');
    }

    /** @test */
    public function can_show_a_quote()
    {
        Http::fake([
            'api.api-ninjas.com/*' => Http::response([
                [
                    "quote" => "The will of man is his happiness.",
                    "author" => "Friedrich Schiller",
                    "category" => "happiness"
                ]
            ]),
        ]);

        // Contexto o escenario
        $url = '/';

        // La acción a realizar
        $response = $this->get($url);

        // El resultado esperado
        $response->assertStatus(200);
        $response->assertSee('The will of man is his happiness.');
        $response->assertSee('Friedrich Schiller');
    }
}
