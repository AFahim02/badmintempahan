<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Pusher\Pusher;

class NotificationController extends Controller
{
    public function index()
    {
        // Fetch notifications for the logged-in user
        $notifications = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::where('is_admin', false)->get();// Fetch all users
        return view('adminpage.notifications', compact('users')); // Pass the users to the view
    }

    public function sendNotification(Request $request)
    {
        \Log::info('Incoming notification request', $request->all());
    
        try {
            // Validate incoming request
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:255',
            ]);
    
            // Create the notification
            $notification = Notification::create([
                'user_id' => $request->user_id,
                'message' => $request->message,
                'read' => false,
            ]);
            

                // Log Pusher credentials to verify loading from the .env file
            \Log::info('Pusher credentials', [
                'key' => env('PUSHER_APP_KEY'),
                'secret' => env('PUSHER_APP_SECRET'),
                'id' => env('PUSHER_APP_ID'),
                'cluster' => env('PUSHER_APP_CLUSTER'),
            ]);

            // Initialize Pusher
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true,
                ]
            );
    
            // Trigger the notification
            $result = $pusher->trigger('notifications', 'new-notification', [
                'id' => $notification->id,
                'message' => $notification->message,
            ]);
            
            \Log::info('Pusher trigger result:', ['result' => $result]); // Log the result from Pusher
    
            // Check if the notification was sent successfully (returns an array on success)
            if (is_array($result)) {
                return response()->json(['success' => true]);
            } else {
                throw new \Exception('Pusher notification failed to send.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error: ' . json_encode($e->errors()));
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('General Error sending notification: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred while sending the notification. Please try again later.'], 500);
        }
    }

    public function deleteNotification($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->delete();

            return response()->json(['success' => true]);
        } catch (\ModelNotFoundException $e) {
            \Log::error('Notification not found: ' . $id);
            return response()->json(['success' => false, 'error' => 'Notification not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error deleting notification: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred while deleting the notification. Please try again later.'], 500);
        }
    }
}