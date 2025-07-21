<?php

// app/Http/Controllers/ReservationController.php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class ReservationController extends Controller
{
    // Display the user's reservations or search results
    public function index(Request $request)
    {
        $query = $request->input('query');

        $reservations = Reservation::where('user_id', Auth::id())->get();

        // Searching for venues based on the query
        $venues = Venue::where('status', 'available')
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where(function ($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                        ->orWhere('location', 'LIKE', "%{$query}%");
                });
            })
            ->get();

        return view('reservations.index', compact('reservations', 'venues'));
    }


    // Show the form to create a new reservation
    public function create($venue_id)
    {
        $venue = Venue::findOrFail($venue_id);
        return view('reservations.create', compact('venue'));
    }

    public function showHistory()
    {
        // Fetch reservations for the authenticated user
        $reservations = Reservation::where('user_id', auth()->id())->with('venue')->get();

        return view('reservations.reservationhistory', compact('reservations'));
    }

    public function store(Request $request)
{
    $request->validate([
        'venue_id' => 'required|exists:venues,id',
        'start_time' => 'required',
        'end_time' => 'required',
        'reservation_date' => 'required|date',
        'event_type' => 'required|string|max:255',
        'contact_number' => 'required|string|max:15',
    ]);

    $existingReservation = Reservation::where('venue_id', $request->venue_id)
        ->where('reservation_date', $request->reservation_date)
        ->where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
        })->exists();

    if ($existingReservation) {
        return redirect()->back()->withErrors(['error' => 'This venue is already booked for the selected time.']);
    }

    try {
        $venue = Venue::findOrFail($request->venue_id);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'venue_id' => $venue->id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'reservation_date' => $request->reservation_date,
            'event_type' => $request->event_type,
            'contact_number' => $request->contact_number,
            'fee' => $venue->fee,
            'payment_status' => 'pending',
        ]);

        // Use ngrok public URL for Toyyibpay callbacks
        $ngrokUrl = 'https://20e135c65efa.ngrok-free.app'; // Update this if ngrok restarts

        // 🔁 Determine ToyyibPay environment
        $isSandbox = env('TOYYIBPAY_SANDBOX', false);
        $baseUrl = $isSandbox ? 'https://dev.toyyibpay.com' : 'https://toyyibpay.com';

        // 🧾 Create ToyyibPay bill
        $response = Http::asForm()->post($baseUrl . '/index.php/api/createBill', [
            'userSecretKey' => env('TOYYIBPAY_USER_SECRET_KEY'),
            'categoryCode' => env('TOYYIBPAY_CATEGORY_CODE'),
            'billName' => 'Venue Reservation',
            'billDescription' => 'Reservation for ' . $venue->name,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $venue->fee * 100,
            'billReturnUrl' => $ngrokUrl . '/payment/callback',
            'billCallbackUrl' => $ngrokUrl . '/payment/callback',
            'billExternalReferenceNo' => $reservation->id,
            'billTo' => Auth::user()->name,
            'billEmail' => Auth::user()->email,
            'billPhone' => $request->contact_number,
        ]);

        // Log the Toyyibpay API response for debugging
        \Log::info('ToyyibPay API Response:', ['response' => $response->json()]);

        if (!$response->ok() || !isset($response[0]['BillCode'])) {
            return redirect()->back()->withErrors(['error' => 'Unable to create payment bill. Please try again.']);
        }

        $billCode = $response[0]['BillCode'];
        $paymentUrl = $baseUrl . '/' . $billCode;

        return redirect()->away($paymentUrl);

    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Could not create reservation. Please try again later.']);
    }
}

    // Show a specific reservation
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    // Show the form to edit a reservation
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $venues = Venue::where('status', 'available')->get();
        return view('reservations.edit', compact('reservation', 'venues'));
    }

    // Update a reservation
    public function update(Request $request, $id)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'event_type' => 'required|string|max:255',
            'reservation_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'contact_number' => 'required|string|max:15',
        ]);

        try {
            $reservation = Reservation::findOrFail($id);

            // Fetch the new venue to get the updated fee
            $venue = Venue::findOrFail($request->venue_id);

            $reservation->update([
                'venue_id' => $request->venue_id,
                'event_type' => $request->event_type,
                'reservation_date' => $request->reservation_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'contact_number' => $request->contact_number,
                'fee' => $venue->fee, // Update the fee based on the selected venue
            ]);

            return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Could not update reservation.']);
        }
    }

    // Delete a reservation
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Could not delete reservation.']);
        }
    }
}
