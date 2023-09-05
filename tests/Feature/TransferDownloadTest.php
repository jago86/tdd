<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transfer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferDownloadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_download_a_stored_transfer()
    {
        Storage::fake();
        $downloadableFile = file_get_contents(base_path('tests/__fixtures__/images.zip'));
        Storage::put('transfers/images.zip', $downloadableFile);
        Storage::assertExists('transfers/images.zip');
        Transfer::factory()->create([
            'id' => 123,
            'file' => 'transfers/images.zip',
        ]);

        $response = $this->get('transfers/123');

        $response->assertStatus(200);
        $response->assertHeader('Content-type', 'application/zip');
        $this->assertEquals($downloadableFile, $response->streamedContent());
    }
}
