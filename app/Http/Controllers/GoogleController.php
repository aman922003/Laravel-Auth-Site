<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Str;

class GoogleController extends Controller
{
    public function index()
    {
        // return Socialite::driver('google')->redirect();
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists with google_id
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::updateOrCreate([
                    'email' => $googleUser->email
                ], [
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)),
                ]);
            } else {
                if ($user) {
                    Auth::login($user);
                    return redirect('/')->with('status', 'Logged in successfully with Google.');
                }
            }
            return redirect('/login')->with('status', 'Google account linked. Please log in.');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Authentication failed: ' . $e->getMessage());
        }
    }
}