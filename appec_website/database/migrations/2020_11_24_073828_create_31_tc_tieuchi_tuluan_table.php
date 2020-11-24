<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create31TcTieuchiTuluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TC_DANHGIA_TULUAN', function (Blueprint $table) {
            $table->increments('idTieuChiTL');
            $table->float('diemTieuChiTL')->nullable()->default(0.0);
            $table->integer('idTL')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanTL')->unsigned()->nullable()->default(12);

            $table->foreign(['idTL','maTieuChuanTL'])->references(['idTL','maTieuChuanTL'])->on('TIEUCHUAN_TULUAN')->onDelete('cascade');
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
        Schema::dropIfExists('TC_DANHGIA_TULUAN');
    }
}
