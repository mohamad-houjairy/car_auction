<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AuctionController;
use Illuminate\Support\Facades\Log;
/////////////////////+ function m controller////////////////////////////////////
class UpdateAuctionStatuses extends Command
{
    protected $signature = 'auctions:update-statuses'; // الأمر الذي سيتم تشغيله
    protected $description = 'Update the status of auctions based on time conditions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {  Log::info("Scheduler is running!");
        app(AuctionController::class)->updateAuctionStatuses();
        $this->info('Auction statuses updated successfully.');
    }
}

