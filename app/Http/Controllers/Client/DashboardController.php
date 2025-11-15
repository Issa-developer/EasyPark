<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ParkingSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $activeSession = ParkingSession::with(['lot', 'spot', 'vehicle'])
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest('started_at')
            ->first();

        $totalSessions = ParkingSession::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalSpent = ParkingSession::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('cost');

        $recentSessions = ParkingSession::with('lot')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest('started_at')
            ->take(5)
            ->get();

        return view('client.dashboard', compact(
            'user', 'activeSession', 'totalSessions', 'totalSpent', 'recentSessions'
        ));
    }

    public function history()
    {
        $user = Auth::user();

        $sessions = ParkingSession::with('lot')
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderByDesc('started_at')
            ->paginate(10);

        return view('client.history.index', compact('user', 'sessions'));
    }
}
