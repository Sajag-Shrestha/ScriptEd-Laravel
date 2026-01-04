<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleRequest;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role === 'Admin') {
                $roleRequests = RoleRequest::with('user')->latest()->get();
                $pendingUsers = User::where('status', 'Pending')->get();
            } else {
                $roleRequests = collect();
                $pendingUsers = collect();
            }
    
            $view->with('roleRequests', $roleRequests)
                 ->with('pendingUsers', $pendingUsers);
        });
    }
}
