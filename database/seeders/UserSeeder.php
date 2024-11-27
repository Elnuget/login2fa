<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Carlos',
            'phone' => '0983468115',
            'email' => 'cangulo009@outlook.es',
            'password' => Hash::make('faplol13'), // La contraseña será encriptada
            'birth_date' => '1999-08-27', // Formato de fecha compatible con MySQL
        ]);

        // New user seed
        User::create([
            'name' => 'usuario',
            'phone' => '1234567890', // Placeholder phone number
            'email' => 'usuario@gmail.com',
            'password' => Hash::make('1234'), // La contraseña será encriptada
            'birth_date' => '2024-11-27', // Updated birth date
        ]);
    }
}
