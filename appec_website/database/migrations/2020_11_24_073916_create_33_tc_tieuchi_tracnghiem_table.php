<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create33TcTieuchiTracnghiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TC_DANHGIA_TRACNGHIEM', function (Blueprint $table) {
            $table->increments('idTieuChiTN');
            $table->float('diemTieuChiTN')->nullable()->default(0.0);
            $table->integer('idTN')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanTN')->unsigned()->nullable()->default(12);

            $table->foreign(['idTN','maTieuChuanTN'])->references(['idTN','maTieuChuanTN'])->on('TIEUCHUAN_TRACNGHIEM')->onDelete('cascade');
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
        Schema::dropIfExists('TC_DANHGIA_TRACNGHIEM');
    }
}
