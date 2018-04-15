<?php

use Illuminate\Database\Seeder;

class OperationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('operacion')->insert([
            'nombre' => 'created',
            'nombre_visible' => 'CREADO'
        ]);

        DB::table('operacion')->insert([
            'nombre' => 'modified',
            'nombre_visible' => 'MODIFICADO'
        ]);

        DB::table('operacion')->insert([
            'nombre' => 'hidden',
            'nombre_visible' => 'OCULTADO'
        ]);

        DB::table('operacion')->insert([
            'nombre' => 'hidden',
            'nombre_visible' => 'PUBLICADO'
        ]);

        DB::table('operacion')->insert([
            'nombre' => 'deleted',
            'nombre_visible' => 'ELIMINADO'
        ]);
    }
}
