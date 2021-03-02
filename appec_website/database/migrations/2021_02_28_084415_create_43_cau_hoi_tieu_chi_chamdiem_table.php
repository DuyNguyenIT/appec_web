<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create43CauHoiTieuChiChamdiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAU_HOI_TCCHAMDIEM', function (Blueprint $table) {
            $table->integer('maCauHoi')->default(12);
            $table->integer('maTCCD')->unsigned()->nullable()->default(12);
            $table->integer('maTCDG')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->primary(['maCauHoi','maTCCD','maTCDG']);
            $table->timestamps();
            $table->foreign('maTCCD')->references('maTCCD')->on('TIEU_CHI_CHAM_DIEM')->onDelete('cascade');
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
        Schema::dropIfExists('CAU_HOI_TCCHAMDIEM');
    }
}
