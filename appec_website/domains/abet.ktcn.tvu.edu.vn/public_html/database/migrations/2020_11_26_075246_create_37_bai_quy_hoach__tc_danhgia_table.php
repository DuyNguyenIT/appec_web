<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create37BaiQuyHoachTCDanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BAIQUYHOACH_TCDANHGIA', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('maBaiQH')->unsigned()->nullable()->default(1);
            $table->integer('maTCDG')->unsigned()->nullable()->default(1);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maBaiQH')->references('maBaiQH')->on('BAI_QUY_HOACH')->onDelete('cascade');
            $table->foreign('maTCDG')->references('maTCDG')->on('TIEUCHUAN_DANHGIA')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('BAIQUYHOACH_TCDANHGIA');
    }
}
