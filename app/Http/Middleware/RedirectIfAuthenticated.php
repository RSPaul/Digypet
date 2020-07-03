<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->user_type == "Provider") {
                return redirect('/provider');
            } else if (Auth::user()->user_type == "User") {
                return redirect('/user');
            } else if (Auth::user()->user_type == "Admin") {
                return redirect('/admin');
            } else {
                return redirect('/user');
            }
        }

        return $next($request);
    }
}
