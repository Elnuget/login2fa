<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards) // Ajusta la declaración aquí
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            $user = Auth::user();
            
            // Si el usuario está eliminado lógicamente, cerrar sesión y redirigir con mensaje
            if ($user->deleted_at) {
                Auth::logout();
                return redirect('/')->withErrors(['account' => 'Esta cuenta ha sido deshabilitada.']);
            }
        }

        // Llamar al método padre solo si el usuario está autenticado y no está eliminado
        return parent::handle($request, $next, ...$guards);
    }
}
