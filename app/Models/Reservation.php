<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'venue_id', // Add this line
        'event_type',
        'reservation_date',
        'start_time',
        'end_time',
        'contact_number',
        'fee', 
        'payment_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // In Reservation.php
    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
