<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch user's vehicles
        $vehicles = Vehicle::where('user_id', $user->id)->get();

        return view('client.vehicles.index', compact('user', 'vehicles'));
    }
}
