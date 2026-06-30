<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ParkingLot;
use App\Models\ParkingSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $lots = ParkingLot::with('spots')->get()->map(function ($lot) {
            return [
    'id'          => $lot->id,
    'name'        => $lot->name,
    'latitude'    => $lot->latitude,
    'longitude'   => $lot->longitude,
    'total_spots' => $lot->total_spots,
    'available'   => $lot->spots->where('status', 'available')->count(),
    'occupied'    => $lot->spots->where('status', 'occupied')->count(),
];
        });

        $totalSessions = ParkingSession::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $activeSession = ParkingSession::with(['lot', 'spot'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest('started_at')
            ->first();

        $recentSessions = ParkingSession::with(['lot', 'spot'])
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest('started_at')
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'user',
            'lots',
            'totalSessions',
            'activeSession',
            'recentSessions'
        ));
    }

    /**
     * Display the parking spot map for a specific lot.
     */
    public function lotMap(ParkingLot $lot)
    {
        $spots = $lot->spots()->orderBy('spot_number')->get();

        return view('client.lots.map', compact('lot', 'spots'));
    }
}