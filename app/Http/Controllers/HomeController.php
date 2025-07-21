<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Payment;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Fetch reservations for the authenticated user
        $reservations = Reservation::with('venue')->where('user_id', Auth::id())->get();

        // Fetch pending payments for reservations that have payment_status 'pending' and event_type is not null
        $pendingPayments = Payment::with('reservation.venue')
            ->where('status', 'pending')
            ->whereHas('reservation', function($query) {
                $query->where('payment_status', 'pending') // Ensure payment_status is pending
                      ->whereNotNull('event_type'); // Ensure event_type is not null
            })
            ->get();

        // Pass both reservations and pending payments to the view
        return view('home', compact('reservations', 'pendingPayments'));
    }
}
