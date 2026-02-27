<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('creator:id,name')
            ->orderBy('start_datetime', 'asc')
            ->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
            'location' => 'nullable|string|max:255',
            'google_form_link' => 'nullable|url|max:500', // Validate as a proper URL
        ]);

        Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_datetime' => $validated['start_datetime'],
            'end_datetime' => $validated['end_datetime'],
            'location' => $validated['location'],
            'google_form_link' => $validated['google_form_link'],
            'created_by' => Auth::id(),
            'is_published' => true, 
        ]);

        return redirect()->back()->with('message', 'Event created successfully!');
    }

    public function showForm(Event $event)
    {
        return Inertia::render('Events/Apply', [
            'event' => $event,
        ]);
    }
}