<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curso::create([
            'nombre' => 'E1I',
            'descripcion' => 'a',
            'precio' => 200.00,
            'estado' => 'activo',
        ]);
    }
}