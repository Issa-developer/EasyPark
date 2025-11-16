<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;


class ParkingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'vehicle_id', 'parking_lot_id', 'parking_spot_id',
        'license_plate_snapshot', 'started_at', 'ended_at',
        'duration_minutes', 'cost', 'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function lot()
    {
        return $this->belongsTo(ParkingLot::class, 'parking_lot_id');
    }

    public function spot()
    {
        return $this->belongsTo(ParkingSpot::class, 'parking_spot_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function notes()
    {
        return $this->hasMany(SpotNote::class);
    }

    // Helper to end session and calculate duration & cost
    public function endSession(): void
    {
        $this->ended_at = now();
        $this->duration_minutes = $this->started_at->diffInMinutes($this->ended_at);

        $hours = max(1, ceil($this->duration_minutes / 60));
        $rate = $this->lot->hourly_rate ?? 0;

        $this->cost = $hours * $rate;
        $this->status = 'completed';
        $this->save();
    }
}
