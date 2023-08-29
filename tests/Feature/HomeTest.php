<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
}
