<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create32CtBaiQuyHoachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_bai_quy_hoach', function (Blueprint $table) {
            $table->increments('maCTBaiQH');
            $table->integer('maLoaiDG')->unsigned()->nullable()->default(1);
            $table->string('maLoaiHTDG',191);
            $table->integer('maBaiQH')->unsigned()->nullable()->default(1);
            $table->integer('trongSo')->unsigned()->nullable()->default(1);
            $table->string('maGV_2',191);
            $table->boolean('isDelete')->nullable()->default(false);
            
            $table->timestamps();
            $table->foreign('maLoaiDG')->references('maLoaiDG')->on('LOAI_DANH_GIA')->onDelete('cascade');
            $table->foreign('maLoaiHTDG')->references('maLoaiHTDG')->on('LOAI_HT_DANHGIA')->onDelete('cascade');
            $table->foreign('maBaiQH')->references('maBaiQH')->on('BAI_QUY_HOACH')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ct_bai_quy_hoach');
    }
}
