<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch payment records for this user
        $payments = Payment::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('client.payments.index', compact('user', 'payments'));
    }
}
