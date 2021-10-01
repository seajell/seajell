<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ('superadmin' == Auth::user()->role || 'admin' == Auth::user()->role) {
            return $next($request);
        } else {
            return redirect('/');
        }
    }
}
