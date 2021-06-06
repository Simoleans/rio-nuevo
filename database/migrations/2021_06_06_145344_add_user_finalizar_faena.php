<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserFinalizarFaena extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('faenas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_finalizar')->unisgned()->after('fecha_final')->nullable();
            $table->foreign('user_finalizar')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faenas', function (Blueprint $table) {
            //
        });
    }
}
