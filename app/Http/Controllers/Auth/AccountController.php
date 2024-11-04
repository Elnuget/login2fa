<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AccountController extends Controller
{
    /**
     * Muestra el formulario de reactivación de cuenta.
     */
    public function showReactivateForm()
    {
        return view('auth.reactivate');
    }

    /**
     * Procesa la reactivación de la cuenta.
     */
    public function reactivate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::withTrashed()->where('email', $request->email)->first();

        if ($user && $user->deleted_at) {
            $user->restore(); // Reactiva la cuenta eliminada
            return redirect()->route('login')->with('status', 'Tu cuenta ha sido reactivada. Puedes iniciar sesión ahora.');
        }

        return back()->withErrors(['email' => 'No se encontró una cuenta desactivada con este correo.']);
    }
}
