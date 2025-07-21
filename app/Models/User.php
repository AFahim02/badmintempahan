<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'id_card_number',
        'is_admin',
        'telegram_chat_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getCustomIdAttribute()
    {
        return 'BTP ' . $this->id; 
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    // Relationship with Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    
}