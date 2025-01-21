<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\GlobalModel;

class CustomAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the remember token from the cookie
        $rememberToken = $request->cookie('kopeg-auth');

        // Check if the token is present
        if ($rememberToken) {
            // Attempt to retrieve the user by the remember token
            $user = GlobalModel::getById('master_user', [['remember_token', $rememberToken]]);

            // If the user is found
            if ($user) {
                // Store user in session if not already stored
                if (!Session::has('auth')) {
                    Session::put('auth', $user);
                }

                // If already authenticated and trying to access login, redirect to home
                if ($request->path() === '/login') {
                    return redirect('/');
                }

                // Proceed with the next request
                return $next($request);
            } else {
                // If user is not found, clear the session and cookie
                Session::forget('auth');
                return redirect('/login')->withCookie(cookie()->forget('kopeg-auth'))->withErrors('Invalid user or token.');
            }
        }

        // If no token and not authenticated, redirect to login
        if (!Session::has('auth')) {
            // Avoid infinite loop by checking if already on the login page
            if ($request->path() !== '/login') {
                return $request->ajax() ? response('UNAUTHORIZED', 401) : redirect('/login');
            }
        }

        // Proceed with the next request
        return $next($request);
    }
}


