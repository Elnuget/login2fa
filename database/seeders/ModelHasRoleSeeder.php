<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asignar roles a modelos
        DB::table('model_has_roles')->insert([
            [
                'role_id' => 1, // ID del rol 'admin'
                'model_type' => 'App\Models\User',
                'model_id' => 1, // ID del usuario
            ],
            
        ]);
    }
}
