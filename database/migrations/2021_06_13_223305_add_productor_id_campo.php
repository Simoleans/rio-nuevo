<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductorIdCampo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campos', function (Blueprint $table) {
            $table->dropColumn(['productor']);
            $table->unsignedBigInteger('productor_id')->nullable()->unisgned();
            $table->foreign('productor_id')->references('id')->on('productors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campos', function (Blueprint $table) {
            //
        });
    }
}
