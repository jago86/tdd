<?php

namespace App\Console\Commands;

use App\Models\Transfer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExpireTransfers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:expire-transfers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $transfers = Transfer::where('created_at', '<=', now()->subDays(8))
            ->get();

        $transfers->each(function (Transfer $transfer) {
            Storage::delete($transfer->file);
            $transfer->delete();
        });
    }
}
