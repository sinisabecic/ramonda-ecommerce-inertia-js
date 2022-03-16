<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
//            return redirect()->back();
            abort(403, 'You are not authorized!');
        }


        return $next($request); // next me vodi na zeljenu rutu
    }
}
