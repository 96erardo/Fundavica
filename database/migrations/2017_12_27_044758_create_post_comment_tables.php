<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 45);
            $table->text('imagen');
            $table->mediumText('contenido');
            $table->timestamps();
            $table->integer('usuario_id')->unsigned();
            $table->integer('categoria_id')->unsigned();
            $table->integer('estado_id')->unsigned();
            
            $table->foreign('usuario_id')->references('id')->on('usuario');           
            $table->foreign('categoria_id')->references('id')->on('categoria');
            $table->foreign('estado_id')->references('id')->on('estado_otros');
        });

        Schema::create('comentario', function (Blueprint $table) {
            $table->increments('id');
            $table->text('contenido');
            $table->timestamps();
            $table->integer('estado_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            $table->integer('publicacion_id')->unsigned();
            $table->integer('respuesta_id')->nullable()->unsigned();
            
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('publicacion_id')->references('id')->on('publicacion');
            $table->foreign('estado_id')->references('id')->on('estado_otros');
        });

        Schema::table('comentario', function(Blueprint $table) {
            $table->foreign('respuesta_id')->references('id')->on('comentario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario');
        Schema::dropIfExists('publicacion');
    }
}
