<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unisgned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('rut');
            $table->string('razon_social');
            $table->string('localidad');
            $table->string('region');
            $table->string('comuna');
            $table->string('direccion');
            $table->string('nombre_responsable');
            $table->string('email');
            $table->string('telefono');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productors');
    }
}
