<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create55MucMucdodgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muc_mucdodg', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_muc')->unsigned()->nullable()->default(1);
            $table->string('maMucDoDG',255);
            $table->timestamps();
            $table->foreign('id_muc')->references('id')->on('muc')->onDelete('cascade');
            $table->foreign('maMucDoDG')->references('maMucDoDG')->on('mucdo_dg')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('55_muc_mucdodg');
    }
}
