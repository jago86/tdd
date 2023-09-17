<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use App\Models\Transfer;
use App\Mail\TransferReceived;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferReceivedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_mailable_content()
    {
        $transfer = Transfer::factory()->create([
            'from_email' => 'john@example.com',
            'to_email' => 'susan@example.com',
        ]);

        $mailable = new TransferReceived($transfer);

        $mailable->assertFrom('john@example.com');
        $mailable->assertTo('susan@example.com');
        $mailable->assertSeeInHtml($transfer->hash);
    }
}
