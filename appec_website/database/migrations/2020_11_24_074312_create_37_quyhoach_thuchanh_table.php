<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create37QuyhoachThuchanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QUYHOACH_THUCHANH', function (Blueprint $table) {
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->integer('maHocPhan')->unsigned()->nullable()->default(12);
            $table->integer('maLoaiDG')->unsigned()->nullable()->default(12);
            $table->text('maGV')->nullable()->default('text');
            $table->text('maLop')->nullable()->default('text');
            $table->integer('idTH')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanTH')->unsigned()->nullable()->default(12);

            $table->foreign(['maHocPhan','maLoaiDG','maGV'])->references(['maHocPhan','maLoaiDG','maGV'])->on('HOCPHAN_LOAIDANHGIA')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('QUYHOACH_THUCHANH');
    }
}
