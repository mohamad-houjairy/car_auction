<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;
use App\Models\User;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'start_price', 'start_time', 'finish_time', 'status', 'highest_bid'];
  
    public function bids() {
        return $this->hasMany(Bid::class);
    }
    public function vendor() {
        return $this->hasOneThrough(User::class, Car::class, 'id', 'id', 'car_id', 'vendor_id');
    }    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function highestBid()
    {
        return $this->bids()->orderByDesc('bid_amount')->first();
    }
       // Define an accessor to calculate the current price
       public function getCurrentPriceAttribute()
       {
           // Get the highest bid or use the start price if no bids exist
           $highestBid = Bid::where('auction_id', $this->id)->max('bid_amount') ?? $this->start_price;
   
           // Calculate the current price (start price + highest bid)
           return $this->start_price + $highestBid;
       }
      
       

}