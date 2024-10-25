<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TempleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check if the user is authenticated using the 'temples' guard
        if (!Auth::guard('temples')->check()) {
            // Redirect to the temple login page
            return redirect()->route('templelogin');
        }

        return $next($request);
    }
}
