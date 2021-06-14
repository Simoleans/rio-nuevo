<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTableVariedad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('variedads', function (Blueprint $table) {
            $table->dropColumn(['tipo_cultivo']);
            $table->unsignedBigInteger('tipo_cultivo_id')->nullable()->unisgned();
            $table->foreign('tipo_cultivo_id')->references('id')->on('tipo_cultivos');
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variedads', function (Blueprint $table) {
            //
        });
    }
}
