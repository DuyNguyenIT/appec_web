<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create36TieuChuanDanhGiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEUCHUAN_DANHGIA', function (Blueprint $table) {
           $table->increments('maTCDG');
           $table->text('tenTCDG')->nullable()->default(null);
           $table->boolean('isDelete')->nullable()->default(false);
           $table->float('diem')->nullable()->default(0);
           $table->integer('maNoiDungQH')->unsigned()->nullable()->default(12);
           $table->foreign('maNoiDungQH')->references('maNoiDungQH')->on('noi_dung_quy_hoach')->onDelete('cascade');
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
        Schema::dropIfExists('TIEUCHUAN_DANHGIA');
    }
}
