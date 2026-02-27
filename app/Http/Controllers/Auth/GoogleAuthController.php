<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Extract the domain from the email
            $email = $googleUser->getEmail();
            $domain = explode('@', $email)[1];

            // Enforce KCA University email domains
            if (!in_array($domain, ['kcau.ac.ke', 'students.kcau.ac.ke'])) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Access Denied. You must use a valid KCA University email to log in.',
                ]);
            }

            // Find or create the user
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => null, // No password needed for SSO
                ]
            );

            // Assign the default 'Student' role if they don't have any role yet
            if (!$user->hasAnyRole(['Incubation Officer', 'Intern', 'Assistant', 'Student'])) {
                $user->assignRole('Student');
            }

            // Log the user in
            Auth::login($user);

            // Redirect to the dashboard
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Something went wrong during the Google authentication process. Please try again.',
            ]);
        }
    }
}