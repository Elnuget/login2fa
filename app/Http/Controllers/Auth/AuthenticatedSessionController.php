<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\TwoFactorCode;

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
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar obtener el usuario
        $user = \App\Models\User::withTrashed()->where('email', $request->input('email'))->first();

        // Verificar si el usuario existe
        if (!$user) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        // Verificar si la cuenta está eliminada
        if ($user->deleted_at) {
            return redirect()->route('account.reactivate', ['email' => $request->email]);
        }

        // Intentar autenticar usando Auth::attempt()
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user(); // Obtener el usuario autenticado

            // Generar código 2FA y notificar al usuario
            $user->generate2FACode();
            $user->notify(new TwoFactorCode());

            // Redirigir al usuario a la vista de 2FA
            return redirect()->route('2fa.index');
        }

        // Si las credenciales son incorrectas
        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
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
