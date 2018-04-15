<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_modifica_p', function (Blueprint $table) {
            $table->timestamp('created_at');
            $table->integer('usuario_id')->unsigned();
            $table->integer('publicacion_id')->unsigned();
            $table->integer('operacion_id')->unsigned();
            $table->primary(['created_at', 'usuario_id', 'publicacion_id']);
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('publicacion_id')->references('id')->on('publicacion');
            $table->foreign('operacion_id')->references('id')->on('operacion');
        });

        Schema::create('u_modifica_c', function (Blueprint $table) {
            $table->timestamp('created_at');
            $table->integer('usuario_id')->unsigned();
            $table->integer('comentario_id')->unsigned();
            $table->integer('operacion_id')->unsigned();
            $table->primary(['created_at', 'usuario_id', 'comentario_id']);
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('comentario_id')->references('id')->on('comentario');
            $table->foreign('operacion_id')->references('id')->on('operacion');
        });

        Schema::create('u_modifica_u', function (Blueprint $table) {
            $table->timestamp('created_at');
            $table->integer('modificador_id')->unsigned();
            $table->integer('modificado_id')->unsigned();
            $table->integer('operacion_id')->unsigned();
            $table->primary(['created_at', 'modificador_id', 'modificado_id']);
            $table->foreign('modificador_id')->references('id')->on('usuario');
            $table->foreign('modificado_id')->references('id')->on('usuario');
            $table->foreign('operacion_id')->references('id')->on('operacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('u_modifica_p');
        Schema::dropIfExists('u_modifica_c');
        Schema::dropIfExists('u_modifica_u');
    }
}
