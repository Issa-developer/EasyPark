<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_session_id', 'invoice_number', 'amount',
        'file_path', 'status',
    ];

    public function session()
    {
        return $this->belongsTo(ParkingSession::class, 'parking_session_id');
    }
}
