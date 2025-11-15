<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpotNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_spot_id', 'parking_session_id', 'created_by', 'note',
    ];

    public function spot()
    {
        return $this->belongsTo(ParkingSpot::class);
    }

    public function session()
    {
        return $this->belongsTo(ParkingSession::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
