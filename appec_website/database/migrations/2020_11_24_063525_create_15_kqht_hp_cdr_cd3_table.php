<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create15KqhtHpCdrCd3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KQHT_HP_CDRCD3', function (Blueprint $table) {
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->integer('maKQHT')->unsigned()->nullable()->default(12);
            $table->timestamps();
            $table->foreign('maCDR3')->references('maCDR3')->on('CDR_CD3')->onDelete('cascade');
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('KQHT_HP_CDRCD3');
    }
}
