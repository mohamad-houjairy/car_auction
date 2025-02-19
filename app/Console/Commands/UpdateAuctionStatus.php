<?php

// app/Console/Commands/UpdateAuctionStatus.php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;

class UpdateAuctionStatus extends Command
{
    protected $signature = 'auctions:update-statuses';
    protected $description = 'Update the status of auctions based on the current time';

    public function handle()
    {
        $now = now();

        // Update auctions to ongoing if the start time has passed
        Auction::where('start_time', '<=', $now)
            ->where('status', 'pending')
            ->update(['status' => 'ongoing']);

        // Optionally, you can also close auctions that have finished
        Auction::where('finish_time', '<=', $now)
            ->where('status', 'ongoing')
            ->update(['status' => 'completed']);

        $this->info('Auction statuses updated successfully.');
    }
}