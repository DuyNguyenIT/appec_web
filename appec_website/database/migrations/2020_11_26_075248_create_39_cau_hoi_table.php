<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create39CauHoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAU_HOI', function (Blueprint $table) {
            $table->increments('maCauHoi');
            $table->text('noiDungCauHoi')->nullable()->default('text');
            $table->float('diemCauHoi')->nullable()->default(123.45);
            $table->integer('maKQHT')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->string('maLoaiHTDG',255);
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')->onDelete('cascade');
            $table->foreign('maLoaiHTDG')->references('maLoaiHTDG')->on('LOAI_HT_DANHGIA')->onDelete('cascade');
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
        Schema::dropIfExists('CAU_HOI');
    }
}
