<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('apellido', 45);
            $table->string('correo', 45);
            $table->string('usuario', 45);
            $table->string('clave', 150);
            $table->integer('tipo');
            $table->integer('estado');
            $table->rememberToken();
            $table->softDeletes();
            $table->tinyInteger('verified');
            $table->string('token', 100);
        });

        Schema::create('categoria', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('color', 45);
        });

        Schema::create('publicación', function(Blueprint $table) {
            $table->increment('id');
            $table->string('titulo', 45);
            $table->text('imagen');
            $table->mediumText('contenido');
            $table->date('fecha');
            $table->integer('usuario_id');
            $table->integer('categoria_id');
            $table->integer('estado');
        });

        Schema::table('publicacion', function(Blueprint $table) {    
            $table->foreign('usuario_id')->references('id')->on('usuario');           
            $table->foreign('categoria_id')->references('id')->on('categoria');
        });

        Schema::create('comentario', function(Blueprint $table) {
            $table->increments('id');
            $table->text('contenido');
            $table->date('fecha');
            $table->integer('estado');
            $table->integer('usuario_id')->unsigned();
            $table->integer('publicacion_id')->unsigned();
        });

        Schema::table('comentario', function(Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('publicacion_id')->references('id')->on('publicacion');
        });

        Schema::create('donacion', function(Blueprint $table){
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('apellido', 45);
            $table->string('cedula', 45);
            $table->string('correo', 45);
            $table->string('medio', 45);
            $table->string('operacion', 45);
            $table->string('monto', 45);
            $table->string('moneda', 45);
            $table->date('fecha');
            $table->string('codigo', 45);
            $table->integer('estado');
        });

        Schema::create('cuenta', function(Blueprint $table) {
            $table->increments('id');
            $table->string('banco');
            $table->string('nro_cuenta');
            $table->integer('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cuenta');
        Schema::drop('donacion');
        Schema::drop('comentario');
        Schema::drop('publicacion');
        Schema::drop('categoria');
        Schema::drop('usuario');
    }
}
