<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingLot;
use App\Models\ParkingSession;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
{
    $lots = ParkingLot::with('spots')->get()->map(function ($lot) {
        $lot->available = $lot->spots->where('status', 'available')->count();
        $lot->occupied  = $lot->spots->where('status', 'occupied')->count();
        return $lot;
    });

    $activeSessions = ParkingSession::with(['lot', 'spot'])
        ->where('status', 'active')
        ->latest('started_at')
        ->get();

    $totalUsers    = User::where('role', 'client')->count();
    $totalSecurity = User::where('role', 'security')->count();
    $totalSessions = ParkingSession::count();
    $totalActive   = ParkingSession::where('status', 'active')->count();

    return view('admin.dashboard', compact(
        'lots',
        'activeSessions',
        'totalUsers',
        'totalSecurity',
        'totalSessions',
        'totalActive'
    ));

    }

    public function sessions(Request $request)
    {
        $query = ParkingSession::with(['lot', 'spot']);

        if ($request->filled('plate')) {
            $query->where('license_plate_snapshot', 'like', '%' . $request->plate . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('lot_id')) {
            $query->where('parking_lot_id', $request->lot_id);
        }

        $sessions = $query->latest('started_at')->paginate(20);

        return response()->json($sessions);
    }

    public function users()
    {
        $users = User::whereIn('role', ['security', 'client'])->get();
        return response()->json($users);
    }

    public function createSecurityGuard(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role'     => 'security',
        'status'   => 'active',
    ]);

    return back()->with('guard_success', 'Security guard account created successfully!');
}

    public function occupancy()
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

        return response()->json($lots);
    }
}