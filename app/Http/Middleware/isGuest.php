<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == False) {
            return $next($request);
        } else {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.doctor.index');
            } else if (Auth::user()->role == 'doctor') {
                return redirect()->route('dokter.dashboard.index');
            } else {
                return redirect()->route('home');
            }
        }
    }
}
