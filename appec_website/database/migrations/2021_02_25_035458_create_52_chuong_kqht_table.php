<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create52ChuongKqhtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuong_kqht', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('machuong')->unsigned()->nullable()->default(1);
            $table->integer('maKQHT')->unsigned()->nullable()->default(1);
            $table->boolean('isdelete')->nullable()->default(false);
            $table->foreign('machuong')->references('id')->on('chuong')->onDelete('cascade');
            $table->foreign('maKQHT')->references('maKQHT')->on('kqht_hp')->onDelete('cascade');
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
        Schema::dropIfExists('52_chuong_kqht');
    }
}
