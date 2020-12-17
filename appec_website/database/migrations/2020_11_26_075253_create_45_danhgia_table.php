<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create45DanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DANH_GIA', function (Blueprint $table) {
            
            $table->increments('maDanhGia');
            $table->integer('maTCCD')->unsigned()->nullable()->default(12);
            $table->float('diemDG')->nullable()->default(123.45);
            $table->integer('lanDG')->unsigned()->nullable()->default(12);
            $table->integer('maPhieuCham')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            
            $table->foreign('maTCCD')->references('maTCCD')->on('TIEU_CHI_CHAM_DIEM')->onDelete('cascade');
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
        Schema::dropIfExists('DANH_GIA');
    }
}
