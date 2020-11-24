<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create30TieuChuanTuluanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEUCHUAN_TULUAN', function (Blueprint $table) {
            $table->increments('idTL');
            $table->increments('maTieuChuanTL');
            $table->primary(['idTL','maTieuChuanTL']);
            $table->text('tenTieuChuanTL')->nullable()->default('text');
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
        Schema::dropIfExists('TIEUCHUAN_TULUAN');
    }
}
