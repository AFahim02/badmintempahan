<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'id_card_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for the image
            'telegram_chat_id' => 'nullable|string|max:255',
        ]);
    
        $user = Auth::user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->id_card_number = $request->id_card_number;
        $user->telegram_chat_id = $request->telegram_chat_id;
    
        // Handle the file upload
        if ($request->hasFile('profile_picture')) {
            // Store the file and get the path
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path; // Save the path in the database
        }
    
        $user->save();
    
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}