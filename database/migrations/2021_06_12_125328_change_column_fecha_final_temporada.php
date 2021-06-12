<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnFechaFinalTemporada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('temporadas', function (Blueprint $table) {
            $table->date('fecha_fin')->nullable()->change();
            $table->tinyInteger('status')->default(1)->after('fecha_fin');
            $table->unsignedBigInteger('user_finalizar')->unisgned()->after('status')->nullable();
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
        Schema::table('temporadas', function (Blueprint $table) {
            //
        });
    }
}
