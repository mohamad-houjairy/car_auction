<?php 

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log; // ✅ Import Log properly

class AuctionEndedNotification extends Notification
{
    use Queueable;

    public $auction;
    public $type;

    public function __construct($auction, $type = null)
    {
        $this->auction = $auction;
        $this->type = $type ?? 'vendor';
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        if (!$this->auction) {
            Log::error('Auction is null in AuctionEndedNotification.');
            return (new MailMessage)->subject('Auction Update')->line('Auction data is missing.');
        }

        if (!$this->auction->car) {
            Log::error('Car is null in AuctionEndedNotification.', ['auction' => $this->auction]);
            return (new MailMessage)->subject('Auction Update')->line('Car data is missing.');
        }

        // ✅ Fix: Use switch instead of match for PHP 7.4 compatibility
        $carName = $this->auction->car->name ?? 'Unknown Car';
        switch ($this->type) {
            case 'win':
                $message = "Congratulations! You have won the auction for {$carName}!";
                break;
            case 'lose':
                $message = "Unfortunately, you did not win the auction for {$carName}.";
                break;
            case 'vendor':
            default:
                $message = "Your auction for {$carName} has ended.";
                break;
        }

        return (new MailMessage)
            ->subject('Auction Update')
            ->line($message)
            ->action('View Auction', url('/auctions/' . $this->auction->id));
    }

    public function toArray($notifiable)
    {
         // ✅ Fix: Use switch instead of match for PHP 7.4 compatibility
         $carName = $this->auction->car->name ?? 'Unknown Car';
         switch ($this->type) {
             case 'win':
                 $message = "Congratulations! You have won the auction for {$carName}!";
                 break;
             case 'lose':
                 $message = "Unfortunately, you did not win the auction for {$carName}.";
                 break;
             case 'vendor':
                $message =  "Your auction for {$carName} has ended.";
                break;
             default:
                 $message = "Your auction for {$carName} has ended.";
                 break;
         }
        return [
            'message' => $message,
            'auction_id' => $this->auction->id
        ];
    }
}
