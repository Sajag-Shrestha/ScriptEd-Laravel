<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($findUser) {
                if (!$findUser->google_id) {
                    $findUser->update(['google_id' => $googleUser->id]);
                }
                Auth::login($findUser);
            } else {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()),
                    'role' => 'Student',
                    'profile_image' => $googleUser->avatar ?? 'uploads/student.png',
                    'last_login' => now(),
                    'email_verified_at' => now(),
                ]);

                Auth::login($user);
            }

            session()->put('user_role', $request->user()->role);
            session()->put('last_google_login', now());

            if ($request->user()->role === 'Admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($request->user()->role === 'Teacher') {
                return redirect()->route('teacher.dashboard');
            } elseif ($request->user()->role === 'Student') {
                return redirect()->route('student.dashboard');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Google login failed. Please try again.');
            return redirect()->route('user.login');
        }
    }
}
