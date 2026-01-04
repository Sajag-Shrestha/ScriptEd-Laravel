<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Update the updated_at timestamp
        $user = $request->user();
        $user->last_login = now();
        $user->save();

        if ($request->user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($request->user()->role === 'Teacher') {
            return redirect()->route('teacher.dashboard');
        }

        if ($request->user()->role === 'Student') {
            return redirect()->route('student.dashboard');
        }

        return redirect()->route('user.login');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
