<?php

use Illuminate\Database\Seeder;

class UserStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_usuario')->insert([
            'nombre' => 'waiting_confirmation',
            'nombre_visible' => 'Pendiente'
        ]);

        DB::table('estado_usuario')->insert([
            'nombre' => 'active',
            'nombre_visible' => 'Activo'
        ]);

        DB::table('estado_usuario')->insert([
            'nombre' => 'banned',
            'nombre_visible' => 'Bloqueado'
        ]);

        DB::table('estado_usuario')->insert([
            'nombre' => 'deleted',
            'nombre_visible' => 'Eliminado'
        ]);
    }
}
