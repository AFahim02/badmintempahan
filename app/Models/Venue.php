<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;

    // Specify which attributes can be mass-assigned
    protected $fillable = [
        'name',
        'description',
        'location',
        'capacity',
        'fee',
        'image_location',
        'status',
    ];


    // In Venue.php
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
}
