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
        $users = User::with('roles')->get();
        return view('users.index', compact('users'))->with('success', 'Mensaje de prueba de éxito');
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
            'phone' => ['nullable', 'string', 'max:15'], // Validación del número de celular
            'birth_date' => ['nullable', 'date'], // Validación de la fecha de nacimiento
            'role' => ['required', 'string'], // Validar que se seleccionó un rol
        ]);

        // Crear el usuario y asignar el rol
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone, // Guardar número de celular
            'birth_date' => $request->birth_date, // Guardar fecha de nacimiento
        ]);

        // Asignar rol al usuario
        $user->assignRole($request->role);

        // Asegurarse de que el model_type sea correcto en la tabla model_has_roles
        \DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->where('model_type', 'AppModelsUser') // buscar el valor incorrecto
            ->update(['model_type' => 'App\Models\User']); // forzar el valor correcto

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
            'phone' => ['nullable', 'string', 'max:15'], // Validación del número de celular
            'birth_date' => ['nullable', 'date'], // Validación de la fecha de nacimiento
            'role' => ['required', 'string'], // Validar que se seleccionó un rol
        ]);

        // Actualizar los datos del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'phone' => $request->phone, // Actualizar número de celular
            'birth_date' => $request->birth_date, // Actualizar fecha de nacimiento
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
