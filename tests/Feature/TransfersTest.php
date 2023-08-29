<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransfersTest extends TestCase
{
    use RefreshDatabase;

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
}
