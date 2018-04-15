<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert([
            'nombre' => 'normal',
            'nombre_visible' => 'Normal'
        ]);

        DB::table('role')->insert([
            'nombre' => 'parent',
            'nombre_visible' => 'Representante'
        ]);

        DB::table('role')->insert([
            'nombre' => 'writer',
            'nombre_visible' => 'Redactor'
        ]);

        DB::table('role')->insert([
            'nombre' => 'admin',
            'nombre_visible' => 'Administrador'
        ]);
    }
}
