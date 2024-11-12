<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Mostrar una lista de usuarios con sus roles.
     */
    public function index()
    {
        $users = User::with('roles')->get(); // Obtener todos los usuarios con sus roles
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all(); // Obtener todos los roles
        return view('users.create', compact('roles'));
    }

    /**
     * Guardar un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'], // Validar que se seleccionó un rol
        ]);

        // Crear el usuario y asignar el rol
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol al usuario
        $user->assignRole($request->role);

        event(new Registered($user));

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito');
    }

    /**
     * Mostrar el formulario para editar un usuario específico.
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Obtener todos los roles
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Actualizar un usuario específico en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        // Validación de datos
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string'], // Validar que se seleccionó un rol
        ]);

        // Actualizar los datos del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Actualizar el rol del usuario
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito');
    }

    /**
     * Eliminar un usuario específico de la base de datos.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito');
    }
}
