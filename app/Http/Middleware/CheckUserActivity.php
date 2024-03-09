<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
// 1. added
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1.2 Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Check if the user's last activity time is older than the specified duration (e.g., 30 minutes)
            if (time() - strtotime($user->last_activity) > 10) { // 30 minutes in seconds, 10 sec used here
                Session::flash('message', 'You have been logged out due to inactivity.');
                Auth::logout();
                Session::flush();

                return redirect()->route('login')->with('error', 'You have been logged out due to inactivity.');
            }

            // Update the user's last activity time
            $user->last_activity = now();
            $user->save();
        }

        return $next($request);
    }
}
