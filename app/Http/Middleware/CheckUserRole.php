<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        // // Check if the user is logged in
        if (Auth::check()) {
            $user = Auth::user();
            // Check if the user's role matches the required role
            if ($user->customRoles($role)) {
                return $next($request);
            } else {
                // User is logged in with the wrong role, redirect to 403 page
                return abort(403);
            }
        } else {
            // User is not logged in, redirect to the relevant login page
            if ($role === 'patient') {
                return redirect()->route('user.signin.get');
            } elseif ($role === 'doctor') {
                return redirect()->route('doctor.signin.get');
            } else {
                // Handle other roles as needed
                return redirect()->route('welcome'); // Redirect to a default page for other roles
            }
        }
    }
}
