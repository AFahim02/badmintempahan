<?php

namespace App\Http\Controllers;

use App\Models\Payment; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;

class PaymentStatusController extends Controller
{
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Fetch payments for the authenticated user
        $payments = $user ? $user->payments()->with('reservation')->get() : collect(); // Ensure payments are fetched only if user is authenticated

        // Check if the payments collection is empty
        if ($payments->isEmpty()) {
            return view('payment.status', compact('payments'))->with('message', 'No payment history found.');
        }

        // Pass the payments data to the view
        return view('payment.status', compact('payments'));
    }
}