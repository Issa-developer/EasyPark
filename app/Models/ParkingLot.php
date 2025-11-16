<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParkingLot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'location', 'total_spots', 'hourly_rate', 'status',
    ];

    public function spots()
    {
        return $this->hasMany(ParkingSpot::class);
    }

    public function sessions()
    {
        return $this->hasMany(ParkingSession::class);
    }

    // Calculated occupancy (number of active or occupied sessions)
    public function currentOccupancy(): int
    {
        return $this->sessions()
            ->where('status', 'active')
            ->count();
    }
}
