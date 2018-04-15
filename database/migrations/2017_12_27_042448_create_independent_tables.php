<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndependentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function(Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('color', 45);
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

        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('nombre_visible', 45);
        });

        Schema::create('estado_usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('nombre_visible', 45);
        });

        Schema::create('estado_otros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('nombre_visible', 45);
        });
        
        Schema::create('operacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 45);
            $table->string('nombre_visible', 45);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuenta');
        Schema::dropIfExists('donacion');
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('role');
        Schema::dropIfExists('estado_usuario');
        Schema::dropIfExists('estado_otros');
        Schema::dropIfExists('operacion');
    }
}
