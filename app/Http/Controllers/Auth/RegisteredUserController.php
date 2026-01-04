<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use function PHPUnit\Framework\returnSelf;

class RegisteredUserController extends Controller
{

    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Validate registration data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = 'Student';

        $profileImage = 'uploads/student.png';

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'role' => 'Student',
            'profile_image' => 'uploads/student.png',
            'last_login' => now(),
            'email_verified_at' => null,
        ]);

        $user->sendEmailVerificationNotification();

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function resendVerificationEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return redirect()->route('verification.notice')->with('message', 'Verification link resent successfully!');
    }
}
