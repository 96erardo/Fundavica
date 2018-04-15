<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoria')->insert([
            'nombre' => 'Fundavica',
            'color' => 'primary'
        ]);

        DB::table('categoria')->insert([
            'nombre' => 'Noticia',
            'color' => 'info'
        ]);

        DB::table('categoria')->insert([
            'nombre' => 'Aviso',
            'color' => 'warning'
        ]);

        DB::table('categoria')->insert([
            'nombre' => 'Urgente',
            'color' => 'danger'
        ]);

        DB::table('categoria')->insert([
            'nombre' => 'Opinión',
            'color' => 'success'
        ]);
    }
}
