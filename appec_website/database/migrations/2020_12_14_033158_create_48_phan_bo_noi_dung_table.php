<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create48PhanBoNoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phan_bo_noi_dung', function (Blueprint $table) {
            $table->increments('maPhanBoND');
            $table->integer('maDe')->unsigned()->nullable()->default(1);
            $table->integer('maKQHT')->unsigned()->nullable()->default(1);
            $table->integer('soCauHoi')->unsigned()->nullable()->default(1);
            $table->integer('diemNhomKQHT')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')->onDelete('cascade');
            $table->foreign('maDe')->references('maDe')->on('de_thi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phan_bo_noi_dung');
    }
}
