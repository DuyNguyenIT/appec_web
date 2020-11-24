<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create26TieuChuanBaocaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TIEUCHUAN_BAOCAO', function (Blueprint $table) {
            $table->increments('idBC');
            $table->increments('maTieuChuanBC');
            $table->primary(['idBC','maTieuChuanBC']);
            $table->text('tenTieuChuanBC')->nullable()->default('text');
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
        Schema::dropIfExists('TIEUCHUAN_BAOCAO');
    }
}
