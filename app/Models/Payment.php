<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Fillable attributes for mass assignment
    protected $fillable = [
        'reservation_id',
        'status',
        'amount',
        'refno',
        'reason',
        'billcode',
        'user_id', // Include user_id here
    ];

    // Define the relationship with the Reservation model
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class); // This links the Payment to the User
    }
}