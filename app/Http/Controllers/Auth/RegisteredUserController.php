<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input, termasuk id_card
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'id_card' => ['required', 'string', 'max:20', 'unique:'.User::class], // Validasi id_card wajib diisi
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Menyimpan data user dengan id_card
        $user = User::create([
            'name' => $request->name,
            'id_card' => $request->id_card, // Menyimpan id_card
            'password' => Hash::make($request->password),
        ]);
    
        // Setelah user berhasil dibuat, login secara otomatis
        event(new Registered($user));
        Auth::login($user);
    
        // Redirect ke halaman production-log setelah berhasil registrasi
        return redirect()->route('production-log.showForm');
    }
    
}
