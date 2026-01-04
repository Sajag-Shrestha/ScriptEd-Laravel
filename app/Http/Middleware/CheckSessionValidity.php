<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckSessionValidity
{
    public function handle($request, Closure $next)
    {
        // Only check authenticated sessions
        if (Auth::check()) {
            $sessionId = Session::getId();
            
            $sessionExists = DB::table('sessions')
                ->where('id', $sessionId)
                ->exists();

            if (!$sessionExists) {
                Auth::logout();
                Session::invalidate();
                return redirect()->route('user.login');
            }
        }

        return $next($request);
    }
}