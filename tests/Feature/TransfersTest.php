<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransfersTest extends TestCase
{
    use RefreshDatabase;

    protected function validParams($overrides = [])
    {
        return array_merge([
            'from_email' => 'john@example.com',
            'to_email' => 'susan@example.com',
            'title' => 'Vacation photos',
            'message' => 'Here I send you the photos',
        ], $overrides);
    }

    /** @test */
    public function a_guest_can_create_transfer()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', [
            'from_email' => 'john@example.com',
            'to_email' => 'susan@example.com',
            'title' => 'Vacation photos',
            'message' => 'Here I send you the photos',
        ]);

        $response->assertStatus(302)
            ->assertRedirect('/');
        $transfer = Transfer::first();
        $this->assertEquals('john@example.com', $transfer->from_email);
        $this->assertEquals('susan@example.com', $transfer->to_email);
        $this->assertEquals('Vacation photos', $transfer->title);
        $this->assertEquals('Here I send you the photos', $transfer->message);
    }

    /** @test */
    public function from_email_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'from_email' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('from_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function from_email_should_be_an_email()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'from_email' => 'invalid-email-format',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('from_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function to_email_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'to_email' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('to_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function to_email_should_be_an_email()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'to_email' => 'invalid-email-format',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('to_email');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function title_is_required()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'title' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function title_should_has_at_least_3_characters()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'title' => 'ab',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('title');
        $this->assertEquals(0, Transfer::count());
    }

    /** @test */
    public function message_is_optional()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'message' => null,
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, Transfer::count());
    }

    /** @test */
    public function message_should_has_at_least_5_characters()
    {
        $this->assertEquals(0, Transfer::count());

        $response = $this->post('/transfers', $this->validParams([
            'message' => 'abcd',
        ]));

        $response->assertStatus(302)
            ->assertRedirect('/');
        $response->assertSessionHasErrors('message');
        $this->assertEquals(0, Transfer::count());
    }
}
