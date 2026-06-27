<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ParkingSession;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index()
    {
        $sessions = ParkingSession::with(['lot', 'spot'])
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->latest('started_at')
            ->paginate(10);

        return view('client.history.index', compact('sessions'));
    }
}
