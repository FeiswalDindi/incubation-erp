<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch the 5 most recent upcoming events that haven't ended yet
        $upcomingEvents = Event::where('is_published', true)
                               ->where('end_datetime', '>=', now())
                               ->orderBy('start_datetime', 'asc')
                               ->take(5)
                               ->get();

        return Inertia::render('Dashboard', [
            'upcomingEvents' => $upcomingEvents
        ]);
    }
}