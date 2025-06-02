<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::where('google_id', $googleUser->id)->first();

    if (!$user) {
        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            $user->google_id = $googleUser->id;
            $user->save();
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => Hash::make('default_password'), // Password is just a placeholder
            ]);
        }
    }
    Auth::login($user);
    return redirect('/');
}
}