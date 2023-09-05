<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_generate_hash()
    {
        $transfer = Transfer::factory()->create(['id' => 456]);

        $this->assertNotNull($transfer->hash);
        $this->assertStringEndsWith(456, $transfer->hash);
    }
}
