<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create32TieuChuanTracnghiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEUCHUAN_TRACNGHIEM', function (Blueprint $table) {
            $table->increments('idTN');
            $table->increments('maTieuChuanTN');
            $table->primary(['idTN','maTieuChuanTN']);
            $table->text('tenTieuChuanTN')->nullable()->default('text');
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
        Schema::dropIfExists('TIEUCHUAN_TRACNGHIEM');
    }
}
