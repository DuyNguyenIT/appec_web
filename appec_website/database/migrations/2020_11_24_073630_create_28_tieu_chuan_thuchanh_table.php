<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create28TieuChuanThuchanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEUCHUAN_THUCHANH', function (Blueprint $table) {
            $table->increments('idTH');
            $table->increments('maTieuChuanTH');
            $table->primary(['idTH','maTieuChuanTH']);
            $table->text('tenTieuChuanTH')->nullable()->default('text');
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
        Schema::dropIfExists('TIEUCHUAN_THUCHANH');
    }
}
