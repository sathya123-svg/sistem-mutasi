<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (trim(Auth::user()->role) !== $role) {
            Auth::logout(); // ⬅️ PENTING
            return redirect()->route('login')
                ->withErrors(['role' => 'Anda tidak memiliki akses.']);
        }

        return $next($request);
    }


}
