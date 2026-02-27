<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class NetworkingController extends Controller
{
    // Shows the grid of all students
    public function index()
    {
        // Fetch all users who have the 'Student' role, and attach their profiles
        $students = User::role('Student')->with('profile')->get();

        return Inertia::render('Networking/Index', [
            'students' => $students
        ]);
    }

    // Shows the form for the logged-in student to edit their own profile
    public function edit()
    {
        $profile = Auth::user()->profile ?? new Profile();

        return Inertia::render('Networking/Edit', [
            'profile' => $profile
        ]);
    }

    // Saves the profile
    public function update(Request $request)
    {
        $validated = $request->validate([
            'headline' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:1000',
            'skills' => 'nullable|string|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        // Update or create the profile for the logged-in user
        Profile::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('networking.index')->with('message', 'Profile updated successfully!');
    }
}