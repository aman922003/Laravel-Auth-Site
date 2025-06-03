<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();
 
        $user = User::updateOrCreate([
            'facebook_id' => $facebookUser->id,
        ], [
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'password' => $facebookUser->password,
        ]);
     
        Auth::login($user);
            
        return redirect('/home');        
    }
}