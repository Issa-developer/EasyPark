<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'parking_lot_id', 'spot_number', 'level', 'zone',
        'type', 'status',
    ];

    public function lot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_lot_id');
    }

    public function sessions()
    {
        return $this->hasMany(ParkingSession::class);
    }

    public function notes()
    {
        return $this->hasMany(SpotNote::class);
    }
}
