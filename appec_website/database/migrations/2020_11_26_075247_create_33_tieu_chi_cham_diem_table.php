<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create33TieuChiChamDiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEU_CHI_CHAM_DIEM', function (Blueprint $table) {
            $table->increments('maTCCD');
            $table->text('tenTCCD')->nullable()->default('text');
            $table->float('diemTCCD')->nullable()->default(123.45);
            $table->integer('maTCDG')->unsigned()->nullable()->default(12);
            $table->timestamps();

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
        Schema::dropIfExists('TIEU_CHI_CHAM_DIEM');
    }
}
