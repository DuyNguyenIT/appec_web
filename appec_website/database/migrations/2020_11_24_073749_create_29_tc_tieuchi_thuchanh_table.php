<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create29TcTieuchiThuchanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TC_DANHGIA_THUCHANH', function (Blueprint $table) {
            $table->increments('idTieuChiTH');
            $table->float('diemTieuChiTH')->nullable()->default(0.0);
            $table->integer('idTH')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanTH')->unsigned()->nullable()->default(12);

            $table->foreign(['idTH','maTieuChuanTH'])->references(['idTH','maTieuChuanTH'])->on('TIEUCHUAN_BAOCAO')->onDelete('cascade');
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
        Schema::dropIfExists('TC_DANHGIA_THUCHANH');
    }
}
