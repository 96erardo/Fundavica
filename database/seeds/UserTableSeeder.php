<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'nombre' => 'Carmen',
            'apellido' => 'Sanchez',
            'correo' => 'fundavica.online@gmail.com',
            'usuario' => 'fundavica',
            'clave' => '$2y$10$Lfjd7Bud915Sk3OcBBSsX.gAoPqnXRkwzriwlPYQC1ZMXRLCZmCTK',
            'created_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'role_id' => 4,
            'estado_id' => 2
        ]);
    }
}
