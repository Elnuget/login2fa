<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Verificar si el usuario está autenticado y tiene el rol de administrador
        if (Auth::check() && Auth::user()->hasRole('admin')) {
            return $next($request);
        }
        return redirect('/'); // Redirige si el usuario no es administrador
    }
}
