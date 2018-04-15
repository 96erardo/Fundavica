<?php

use Illuminate\Database\Seeder;

class PostStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_otros')->insert([
            'nombre' => 'hide',
            'nombre_visible' => 'Oculto'
        ]);

        DB::table('estado_otros')->insert([
            'nombre' => 'active',
            'nombre_visible' => 'Activo'
        ]);

        DB::table('estado_otros')->insert([
            'nombre' => 'deleted',
            'nombre_visible' => 'Eliminado'
        ]);
    }
}
