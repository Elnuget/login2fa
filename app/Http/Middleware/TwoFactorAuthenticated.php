<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthenticated
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
        $user = Auth::user();

        // Comprueba si el usuario está autenticado y requiere 2FA
        if ($user && $user->two_factor_code && $user->two_factor_expires_at->isFuture()) {
            // Redirige a la página de 2FA si no se ha completado
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }
}
