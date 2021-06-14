<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAllTableReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reportes', function (Blueprint $table) {
            $table->dropColumn(['productor','campo','maquina','tipo_cultivo','petroleo','hectareas','cuartel']);
            $table->unsignedBigInteger('productor_id')->nullable()->unisgned();
            $table->foreign('productor_id')->references('id')->on('productors');
            $table->unsignedBigInteger('campo_id')->nullable()->unisgned();
            $table->foreign('campo_id')->references('id')->on('campos');
            $table->unsignedBigInteger('maquina_id')->nullable()->unisgned();
            $table->foreign('maquina_id')->references('id')->on('machines');
            $table->unsignedBigInteger('tipo_cultivo_id')->nullable()->unisgned();
            $table->foreign('tipo_cultivo_id')->references('id')->on('tipo_cultivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reportes', function (Blueprint $table) {
            //
        });
    }
}
