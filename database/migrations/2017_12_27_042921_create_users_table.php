<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->unique('correo');
            $table->string('usuario', 45);
            $table->unique('usuario');
            $table->string('clave', 150);
            $table->rememberToken();
            $table->string('verifyme_token', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('role_id')->unsigned();
            $table->integer('estado_id')->unsigned();
            
            $table->foreign('role_id')->references('id')->on('role');
            $table->foreign('estado_id')->references('id')->on('estado_usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
