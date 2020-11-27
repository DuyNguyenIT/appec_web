<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create38CauHoiTieuChiChamdiemTable extends Migration
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
            
            $table->primary(['maCauHoi','maTCCD']);
            $table->timestamps();
            $table->foreign('maTCCD')->references('maTCCD')->on('TIEU_CHI_CHAM_DIEM')->onDelete('cascade');

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
