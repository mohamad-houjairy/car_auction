<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'brand',
        'model',
        'body_type',
        'door_count',
        'color',
        'mileage',
        'power',
        'description',
        'images', // Ensure this is stored as JSON in the database
    ];

    // ✅ Relationship: A car belongs to a user (vendor)
    public function user()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // ✅ Relationship: A car has one auction
    public function auction()
    {
        return $this->hasOne(Auction::class);
    }
}
