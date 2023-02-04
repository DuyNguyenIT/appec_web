<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable59DanhgiaTuluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danhgia_tuluan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('maPATL')->unsigned()->nullable()->default(1);
            $table->integer('maPhieuCham')->unsigned()->nullable()->default(1);
            $table->float('diemDG')->nullable()->default(0.0);
            $table->integer('lanDG')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->foreign('maPATL')->references('id')->on('phuong_an_tu_luan')->onDelete('cascade');
            $table->foreign('maPhieuCham')->references('maPhieuCham')->on('phieu_cham')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_59_danhgia_tuluan');
    }
}
