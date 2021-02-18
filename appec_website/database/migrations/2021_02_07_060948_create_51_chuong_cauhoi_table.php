<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create51ChuongCauhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuong_cauhoi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('maChuong')->unsigned()->nullable()->default(1);
            $table->integer('maCauHoi')->unsigned()->nullable()->default(1);
            $table->foreign('maChuong')->references('id')->on('chuong')->onDelete('cascade');
            $table->foreign('maCauHoi')->references('maCauHoi')->on('cau_hoi')->onDelete('cascade');
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
        Schema::dropIfExists('51_chuong_cauhoi');
    }
}
