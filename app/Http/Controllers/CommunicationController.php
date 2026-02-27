<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\IncubationAnnouncement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;

class CommunicationController extends Controller
{
    public function index()
    {
        // Count how many students we are about to email
        $studentCount = User::role('Student')->count();

        return Inertia::render('Communication/Index', [
            'studentCount' => $studentCount
        ]);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $students = User::role('Student')->get();

        // Loop through all students and send the email
        foreach ($students as $student) {
            Mail::to($student->email)->send(
                new IncubationAnnouncement($validated['subject'], $validated['message'])
            );
        }

        return redirect()->back()->with('message', "Announcement successfully dispatched to {$students->count()} students!");
    }
}