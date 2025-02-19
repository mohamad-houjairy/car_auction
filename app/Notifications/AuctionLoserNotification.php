<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class AuctionLoserNotification extends Notification implements ShouldQueue
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
                    ->subject('Auction Ended - You Lost')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('Unfortunately, you did not win the auction for the car: ' . $this->auction->car->name)
                    ->line('Thank you for your participation!')
                    ->action('View Auctions', url('/auctions'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You lost the auction for ' . $this->auction->car->name,
            'auction_id' => $this->auction->id
        ];
    }
}
