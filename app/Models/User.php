<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Auction;
use App\Models\Favorite;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Mass assignable attributes
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'shop_name', 
        'shop_url', 
        'phone_number', 
    ];

    // Hidden attributes
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    // A user (vendor) can have multiple cars
    public function cars()
    {
        return $this->hasMany(Car::class, 'vendor_id');
    }

    // A user can place multiple bids
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // A user can create multiple auctions
    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }
}
