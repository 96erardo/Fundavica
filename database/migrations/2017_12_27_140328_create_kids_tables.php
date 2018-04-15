<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKidsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kid', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->string('apellido', 50);
        });

        Schema::create('u_representa_k', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned();
            $table->integer('kid_id')->unsigned();
            $table->primary(['usuario_id', 'kid_id']);            
            $table->foreign('usuario_id')->references('id')->on('usuario');
            $table->foreign('kid_id')->references('id')->on('kid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('u_representa_k');
        Schema::dropIfExists('kid');
    }
}
