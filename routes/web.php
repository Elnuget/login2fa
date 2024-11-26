<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PagoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::post('/reactivate-account-request', [AccountController::class, 'reactivateRequest'])->name('account.reactivate.request');
Route::get('/reactivate-account', [AccountController::class, 'showReactivateForm'])->name('account.reactivate');
Route::post('/reactivate-account', [AccountController::class, 'reactivate'])->name('account.reactivate.submit');
// Rutas de verificación 2FA sin middleware '2fa'
Route::get('/2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');
Route::post('/2fa/resend', [TwoFactorController::class, 'resend'])->name('2fa.resend');

//usuarios
Route::middleware(['auth', 'verified', '2fa'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('pagos', PagoController::class);
    Route::post('pagos/{pago}/verify', [PagoController::class, 'verify'])->name('pagos.verify');
    Route::post('pagos/{pago}/reject', [PagoController::class, 'reject'])->name('pagos.reject');
});

//administrador
Route::middleware(['auth', 'admin', 'verified', '2fa'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('cursos', CursoController::class);
    
});


require __DIR__ . '/auth.php';
