<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\ParkingLot;
use App\Models\ParkingSpot;
use App\Models\ParkingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    // Show all lots with current occupancy
   public function index()
{
    $lots = ParkingLot::with('spots')->get()->map(function ($lot) {
        return [
            'id'          => $lot->id,
            'name'        => $lot->name,
            'total_spots' => $lot->total_spots,
            'available'   => $lot->spots->where('status', 'available')->count(),
            'occupied'    => $lot->spots->where('status', 'occupied')->count(),
        ];
    });

    $activeSessions = ParkingSession::with(['lot', 'spot'])
        ->where('status', 'active')
        ->latest('started_at')
        ->get();

    return view('security.dashboard', compact('lots', 'activeSessions'));
}

public function entry(Request $request)
{
    $request->validate([
        'license_plate'  => 'required|string|max:20',
        'parking_lot_id' => 'required|exists:parking_lots,id',
    ]);

    $plate = strtoupper(trim($request->license_plate));

    $existing = ParkingSession::where('license_plate_snapshot', $plate)
        ->where('status', 'active')
        ->first();

    if ($existing) {
        return back()->with('entry_error', "Vehicle $plate already has an active session.");
    }

    $spot = ParkingSpot::where('parking_lot_id', $request->parking_lot_id)
        ->where('status', 'available')
        ->first();

    if (!$spot) {
        return back()->with('entry_error', 'No available spots in this parking lot.');
    }

    $spot->update(['status' => 'occupied']);

    ParkingSession::create([
        'parking_lot_id'         => $request->parking_lot_id,
        'parking_spot_id'        => $spot->id,
        'license_plate_snapshot' => $plate,
        'started_at'             => now(),
        'status'                 => 'active',
        'user_id'                => null,
        'vehicle_id'             => null,
    ]);

    return back()->with('entry_success', "Vehicle $plate logged in successfully.");
}

public function exit(Request $request)
{
    $request->validate([
        'license_plate' => 'required|string|max:20',
    ]);

    $plate = strtoupper(trim($request->license_plate));

    $session = ParkingSession::where('license_plate_snapshot', $plate)
        ->where('status', 'active')
        ->first();

    if (!$session) {
        return back()->with('exit_error', "No active session found for $plate.");
    }

    if ($session->spot) {
        $session->spot->update(['status' => 'available']);
    }

    $session->endSession();

    return back()->with('exit_success', "Vehicle $plate logged out. Duration: {$session->duration_minutes} minutes.");
}
}