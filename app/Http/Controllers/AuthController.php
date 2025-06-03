<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Mail\LoginNotification;
use Illuminate\Support\Facades\Mail;
use Str;


class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed|min:6',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
            ]);
            $profilePhotoPath = null;

            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
            }
            // dd($profilePhotoPath);
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'profile_photo' => $profilePhotoPath,
                'role' => 'user',
            ]);

            return redirect('/login')->with('success', 'Registered successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6'
        ]);
        $user = User::where('email', $request->email)->first();
        $credentials = $request->only('email', 'password');
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Mail::to($user->email)->send(new LoginNotification($user));
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'user' => redirect()->route('user.dashboard'),
                default => redirect()->route('home')->with('error', 'Unauthorized role.'),
            };
        }

        return back()->with('error', 'Invalid email or password.');
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }


    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

}