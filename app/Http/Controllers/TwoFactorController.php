<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\TwoFactorCode; // Asegúrate de importar la notificación

class TwoFactorController extends Controller
{
    // Muestra el formulario para ingresar el código 2FA
    public function index()
    {
        return view('auth.2fa');
    }

    // Verifica el código 2FA
    public function verify(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = Auth::user();

        // Verifica si el código es correcto y aún no ha expirado
        if ($request->two_factor_code == $user->two_factor_code && $user->two_factor_expires_at->isFuture()) {
            // Resetea el código para evitar reutilización
            $user->resetTwoFactorCode();

            // Redirige al dashboard
            return redirect()->intended('dashboard');
        }

        // Si el código es incorrecto o ha expirado, regresa con un mensaje de error
        return back()->with('error', 'El código es incorrecto o ha expirado.');
    }

    // Reenvía el código 2FA
    public function resend(Request $request)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();

        // Generar un nuevo código de verificación
        $newCode = $this->generateTwoFactorCode($user);

        // Enviar el código mediante la notificación
        $user->notify(new TwoFactorCode());

        // Opcional: Mensaje de éxito
        return response()->json(['message' => 'Código reenviado.']);
    }

    protected function generateTwoFactorCode($user)
    {
        // Genera un nuevo código
        $code = rand(100000, 999999); // Puedes usar un método diferente si lo prefieres

        // Establece el nuevo código y la expiración
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(10); // Establece la expiración a 10 minutos
        $user->save();

        return $code;
    }
}
