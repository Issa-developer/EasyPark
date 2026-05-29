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
                'total_spots' => $lot->total_spots,
                'available'   => $lot->spots->where('status', 'available')->count(),
                'occupied'    => $lot->spots->where('status', 'occupied')->count(),
            ];
        });

        $totalSessions = ParkingSession::where('status', 'completed')->count();

        $totalSpent = ParkingSession::where('status', 'completed')->sum('cost');

        $activeSession = ParkingSession::with(['lot', 'spot'])
            ->where('status', 'active')
            ->latest('started_at')
            ->first();

        $recentSessions = ParkingSession::with(['lot', 'spot'])
            ->where('status', 'completed')
            ->latest('started_at')
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'user',
            'lots',
            'totalSessions',
            'totalSpent',
            'activeSession',
            'recentSessions'
        ));
    }
}