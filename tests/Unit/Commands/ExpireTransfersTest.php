<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use App\Models\Transfer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExpireTransfersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_expire_and_delete_transfers()
    {
        Storage::fake();
        $downloadableFile = file_get_contents(base_path('tests/__fixtures__/images.zip'));
        Storage::put('transfers/imagesA.zip', $downloadableFile);
        Storage::assertExists('transfers/imagesA.zip');
        $downloadableFile = file_get_contents(base_path('tests/__fixtures__/images.zip'));
        Storage::put('transfers/imagesB.zip', $downloadableFile);
        Storage::assertExists('transfers/imagesB.zip');
        $transferA = Transfer::factory()->create([
            'file' => 'transfers/imagesA.zip',
            'created_at' => now()->subDays(8),
        ]);
        $transferB = Transfer::factory()->create([
            'file' => 'transfers/imagesB.zip',
            'created_at' => now()->subDays(7),
        ]);

        $this->artisan('app:expire-transfers');

        $this->assertNull($transferA->fresh());
        $this->assertNotNull($transferB->fresh());
        Storage::assertMissing('transfers/imagesA.zip');
        Storage::assertExists('transfers/imagesB.zip');
    }
}
