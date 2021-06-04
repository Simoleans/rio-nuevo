<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unisgned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('productor');
            $table->string('campo');
            $table->string('maquina');
            $table->string('tipo_cultivo');
            $table->string('variedad');
            $table->string('cuartel');
            $table->string('tipo_bandeja');
            $table->string('nro_bandeja');
            $table->integer('kg_totales');
            $table->integer('kg_teoricos');
            $table->integer('petroleo');
            $table->integer('hectareas');
            $table->integer('hs_maquina');
            $table->longText('observacion');
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
        Schema::dropIfExists('reportes');
    }
}
