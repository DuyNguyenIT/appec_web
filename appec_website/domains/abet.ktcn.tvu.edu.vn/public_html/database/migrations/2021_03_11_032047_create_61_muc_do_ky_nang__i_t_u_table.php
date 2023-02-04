<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create61MucDoKyNangITUTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muc_do_ky_nang_itu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chuong')->unsigned()->nullable()->default(1);  //mã chương
            $table->integer('maCDR1')->unsigned()->nullable()->default(1);  //mã chuẩn đầu ra 1
            $table->text('ky_nang')->nullable()->default(null);  //chữ U, T, I
            $table->integer('maKQHT')->unsigned()->nullable()->default(1); //mã kết quả học tập
            $table->timestamps();
            $table->foreign('id_chuong')->references('id')->on('chuong')->onDelete('cascade');
            $table->foreign('maCDR1')->references('maCDR1')->on('cdr_cd1')->onDelete('cascade');
            $table->foreign('maKQHT')->references('maKQHT')->on('kqht_hp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('61_muc_do_ky_nang__i_t_u');
    }
}
