<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_card' => ['required', 'string', 'exists:users,id_card'],
            'password' => ['required', 'string'],
        ]);
    
        if (Auth::attempt(['id_card' => $request->id_card, 'password' => $request->password])) {
            $request->session()->regenerate();
    
            
    
            return redirect()->route('production-log.showForm'); 
        }
    
        return back()->withErrors([
            'id_card' => 'The provided credentials are incorrect.',
        ]);
    }
    

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
