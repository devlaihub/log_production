<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        logger('Session ID saat akses ulang', [
            'id' => session()->getId(),
            'user_id' => Auth::id(),
            'session_user_id' => session('user_id'),
            'cookies' => $request->cookies->all(),
        ]);

        if (! Auth::check()) {
            return redirect('http://localhost:8000/login');  // Pastikan 'login' adalah route yang benar
        }
        
        return $next($request);
    }
}
