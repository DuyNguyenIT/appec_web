<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create8HocPhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOC_PHAN', function (Blueprint $table) {
            $table->string('maHocPhan',191)->unique();
            $table->primary('maHocPhan');
            $table->text('tenHocPhan')->nullable()->default(null);
            $table->integer('tongSoTinChi')->unsigned()->nullable()->default(1);
            $table->integer('tinChiLyThuyet')->unsigned()->nullable()->default(1);
            $table->integer('tinChiThucHanh')->unsigned()->nullable()->default(1);
            $table->longText('yeuCau')->nullable()->default(null);
            $table->text('moTaHocPhan')->nullable()->default(null);
            $table->integer('dacTrung')->unsigned()->nullable()->default(0);

            $table->boolean('isDelete')->nullable()->default(false);
            $table->boolean('trangThai')->nullable()->default(false);
           
            $table->string('maCTKhoiKT',255);
            $table->timestamps();

            $table->foreign('maCTKhoiKT')->references('maCTKhoiKT')->on('CT_KHOI_KIEN_THUC')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HOC_PHAN');
    }
}
