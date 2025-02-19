<?php

// app/Console/Commands/CloseAuctions.php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;

class CloseAuctions extends Command
{
    protected $signature = 'auctions:close';
    protected $description = 'Close auctions that have reached their end time';

    public function handle()
    {
        $auctions = Auction::where('finish_time', '<=', now())
                           ->where('status', 'ongoing')
                           ->get();

        foreach ($auctions as $auction) {
            $auction->update(['status' => 'completed']);
        }

        $this->info('Closed ' . $auctions->count() . ' auctions.');
    }
}