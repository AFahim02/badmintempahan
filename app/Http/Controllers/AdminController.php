<?php

namespace App\Http\Controllers;

use App\Models\Reservation; // Import the Reservation model
use App\Models\Venue;
use App\Models\Payment; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Telegram\Bot\Api;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with reservation and venue statistics.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $totalReservations = Reservation::count();
        $totalVenues = Venue::count();

        return view('adminpage.dashboard.index', [
            'totalReservations' => $totalReservations,
            'totalVenues' => $totalVenues,
        ]);
    }

     public function profile()
    {
        return view('adminpage.adminlayout.home');
    }

    /**
     * Display the reservations index page.
     *
     * @return \Illuminate\View\View
     */
    public function reservationsIndex()
    {
        $reservations = Reservation::all();
        return view('adminpage.reservation.index', compact('reservations'));
    }

    /**
     * Display the venues management page with optional search.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function venues(Request $request)
    {
        $query = $request->input('query');

        // Fetch venues based on the search query
        $venues = Venue::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'LIKE', "%{$query}%")
                                 ->orWhere('location', 'LIKE', "%{$query}%");
        })->get(); // Get the venues, filtered by the search query

        return view('adminpage.venues.index', compact('venues', 'query')); // Pass venues and query to the view
    }

    /**
     * Show the form for creating a new venue.
     *
     * @return \Illuminate\View\View
     */
    public function createVenue()
    {
        return view('adminpage.venues.create'); // Pass any necessary data if needed
    }

    /**
     * Store a newly created venue in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeVenue(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|max:5000',
            'fee' => 'required|numeric|min:0',
            'image_location' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the uploaded image
        $imagePath = $request->file('image_location')->store('venues', 'public');

        // Attempt to create a new venue
        try {
            Venue::create([
                'name' => $request->name,
                'description' => $request->description,
                'location' => $request->location,
                'capacity' => $request->capacity,
                'fee' => $request->fee,
                'image_location' => $imagePath,
                'status' => 'available', // Default status
            ]);

            return redirect()->route('admin.venues.index')->with('success', 'Venue created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['general' => 'There was an error creating the venue.']);
        }
    }

    /**
     * Show a specific reservation for editing or details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function showReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('adminpage.ReservationDetail', compact('reservation'));
    }

    /**
     * Show the form for creating a new reservation.
     *
     * @return \Illuminate\View\View
     */
    public function createReservation()
    {
        return view('adminpage.CreateReservation');
    }

    /**
     * Store a newly created reservation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReservation(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'reservation_date' => 'required|date',
            'payment_status' => 'required|string',
            // Add other fields as needed
        ]);

        // Create a new reservation
        Reservation::create($request->only(['customer_name', 'reservation_date', 'payment_status'])); // Add other fields as needed

        return redirect()->route('admin.reservations.index')->with('success', 'Reservation created successfully.');
    }

    /**
     * Show the form for editing a venue.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editVenue($id)
    {
        $venue = Venue::findOrFail($id);
        return view('adminpage.venues.edit', compact('venue'));
    }

    /**
     * Update a venue in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|max:5000',
            'fee' => 'required|numeric|min:0',
            'image_location' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,unavailable', // Ensure valid status
        ]);

        // Find the venue
        $venue = Venue::findOrFail($id);

        // Update the venue details
        $venue->name = $request->name;
        $venue->description = $request->description;
        $venue->location = $request->location;
        $venue->capacity = $request->capacity;
        $venue->fee = $request->fee;
        
        // Handle image upload if a new image is provided
        if ($request->hasFile('image_location')) {
            // Handle the uploaded image
            $imagePath = $request->file('image_location')->store('venues', 'public');
            $venue->image_location = $imagePath;
        }

        // Update the status
        $venue->status = $request->status;

        // Save the changes
        $venue->save();

        // Redirect to the venues index page with a success message
        return redirect()->route('admin.venues.index')->with('success', 'Venue updated successfully.');
    }

    /**
     * Remove a venue from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyVenue($id)
    {
        $venue = Venue::findOrFail($id);
        
        // Optionally delete the image from storage
        if ($venue->image_location) {
            Storage::disk('public')->delete($venue->image_location);
        }
        
        $venue->delete();

        return redirect()->route('admin.venues.index')->with('success', 'Venue deleted successfully.');
    }

    public function paymentStatus()
    {
        return view('adminpage.payment.index');
    }

    /**
     * Display all user payment history.
     *
     * @return \Illuminate\View\View
     */
    public function paymentHistory()
    {
        $payments = Payment::with('user')->get(); // Fetch all payments with user relationship
        return view('adminpage.payment.index', compact('payments')); // Pass payments to the view
    }

    /**
     * Display the notifications page.
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('adminpage.CurrentValue');
    }

    public function remindReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $user = $reservation->user;

        // Send Telegram notification if user has chat ID
        if ($user && $user->telegram_chat_id) {
            try {
                $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
                $message = "Reminder: Your reservation (ID: {$reservation->id}) for \"{$reservation->venue->name}\" on " .
                    \Carbon\Carbon::parse($reservation->reservation_date)->format('Y-m-d') .
                    " from " . \Carbon\Carbon::parse($reservation->start_time)->format('H:i') .
                    " to " . \Carbon\Carbon::parse($reservation->end_time)->format('H:i') .
                    " is still pending payment. Please complete your payment to confirm your booking.";
                $telegram->sendMessage([
                    'chat_id' => $user->telegram_chat_id,
                    'text' => $message,
                ]);
            } catch (\Exception $e) {
                \Log::error('Telegram reminder failed: ' . $e->getMessage());
            }
        }

        // Send Pusher notification (dashboard)
        try {
            $notification = new \App\Models\Notification();
            $notification->user_id = $user->id;
            $notification->message = $message;
            $notification->read = false;
            $notification->save();

            // Optionally, trigger Pusher event here if you want real-time
        } catch (\Exception $e) {
            \Log::error('Dashboard reminder notification failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Reminder sent to user.');
    }

    public function deleteReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        if ($reservation->payment_status == 'pending') {
            $reservation->delete();
            return redirect()->back()->with('success', 'Reservation deleted.');
        }
        return redirect()->back()->with('error', 'Only pending reservations can be deleted.');
    }
}