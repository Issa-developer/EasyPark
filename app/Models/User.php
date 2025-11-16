<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role', 'status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function parkingSessions()
    {
        return $this->hasMany(ParkingSession::class);
    }

    public function spotNotes()
    {
        return $this->hasMany(SpotNote::class, 'created_by');
    }

    // Helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSecurity(): bool
    {
        return $this->role === 'security';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

}
