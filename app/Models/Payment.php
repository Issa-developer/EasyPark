<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'reference',
        'status',
        'session_id',
    ];

    // Each payment belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optional — associate payment with a parking session
    public function session()
    {
        return $this->belongsTo(ParkingSession::class, 'session_id');
    }
}
