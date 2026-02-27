<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- PUBLIC WEBSITE ROUTES ---
Route::get('/', function () {
    $upcomingEvents = \App\Models\Event::where('is_published', true)
        ->where('end_datetime', '>=', now())
        ->orderBy('start_datetime', 'asc')
        ->take(3)->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'upcomingEvents' => $upcomingEvents,
    ]);
})->name('home');

Route::get('/about', function () {
    return Inertia::render('Public/About', ['canLogin' => Route::has('login')]);
})->name('about');

Route::get('/contact', function () {
    return Inertia::render('Public/Contact', ['canLogin' => Route::has('login')]);
})->name('contact');
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// Event Management & Application Routes
    Route::get('/events', [\App\Http\Controllers\EventController::class, 'index'])->name('events.index');
    Route::post('/events', [\App\Http\Controllers\EventController::class, 'store'])->name('events.store');
    Route::get('/events/apply/{event:slug}', [\App\Http\Controllers\EventController::class, 'showForm'])->name('events.apply');

    // Application Form Routes (Using the slug to find the event automatically)
    Route::get('/events/apply/{event:slug}', [\App\Http\Controllers\EventController::class, 'showForm'])->name('events.apply');
    Route::post('/events/apply/{event:slug}', [\App\Http\Controllers\EventController::class, 'submitApplication'])->name('events.submit');

    // Form Template Builder Routes
    Route::get('/templates/create', [\App\Http\Controllers\FormTemplateController::class, 'create'])->name('templates.create');
    Route::post('/templates', [\App\Http\Controllers\FormTemplateController::class, 'store'])->name('templates.store');

    // Admin Application Review Route
    Route::get('/events/{event:slug}/applications', [\App\Http\Controllers\EventController::class, 'viewApplications'])->name('events.applications');


    // Resource Directory Routes
    Route::get('/resources', [\App\Http\Controllers\ResourceLinkController::class, 'index'])->name('resources.index');
    Route::post('/resources', [\App\Http\Controllers\ResourceLinkController::class, 'store'])->name('resources.store');
    Route::delete('/resources/{resource}', [\App\Http\Controllers\ResourceLinkController::class, 'destroy'])->name('resources.destroy');
   
   // Mass Communication Routes
    Route::get('/communication', [\App\Http\Controllers\CommunicationController::class, 'index'])->name('communication.index');
    Route::post('/communication/send', [\App\Http\Controllers\CommunicationController::class, 'send'])->name('communication.send');

    // Student Networking Routes
    Route::get('/networking', [\App\Http\Controllers\NetworkingController::class, 'index'])->name('networking.index');
    Route::get('/networking/my-profile', [\App\Http\Controllers\NetworkingController::class, 'edit'])->name('networking.edit');
    Route::post('/networking/my-profile', [\App\Http\Controllers\NetworkingController::class, 'update'])->name('networking.update');
    });

// Google SSO Routes
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

require __DIR__.'/auth.php';