<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaenasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faenas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unisgned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('productor');
            $table->string('campo');
            $table->string('maquina');
            $table->date('fecha_inicio');
            $table->date('fecha_final')->nullable();
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
        Schema::dropIfExists('faenas');
    }
}
