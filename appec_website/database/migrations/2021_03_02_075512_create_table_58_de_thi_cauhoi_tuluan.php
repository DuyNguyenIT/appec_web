<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable58DeThiCauhoiTuluan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('de_thi_cauhoi_tuluan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('maDe')->unsigned()->nullable()->default(12);
            $table->integer('maCauHoi')->unsigned()->nullable()->default(1);
            $table->integer('maPATL')->unsigned()->nullable()->default(12);
            $table->timestamps();
            $table->foreign('maDe')->references('maDe')->on('de_thi')->onDelete('cascade');
            $table->foreign('maCauHoi')->references('maCauHoi')->on('cau_hoi')->onDelete('cascade');
            $table->foreign('maPATL')->references('id')->on('phuong_an_tu_luan')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_58_de_thi_cauhoi_tuluan');
    }
}
