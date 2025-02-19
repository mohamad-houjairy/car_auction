<?php namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class AuctionWinnerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $auction;

    public function __construct($auction)
    {
        $this->auction = $auction;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Congratulations! You Won the Auction')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('You have won the auction for the car: ' . $this->auction->car->name)
                    ->action('View Auction', url('/auctions/' . $this->auction->id))
                    ->line('Thank you for participating!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You won the auction for ' . $this->auction->car->name,
            'auction_id' => $this->auction->id
        ];
    }
}
