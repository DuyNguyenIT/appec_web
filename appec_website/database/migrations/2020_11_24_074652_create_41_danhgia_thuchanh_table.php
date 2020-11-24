<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create41DanhgiaThuchanhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DANHGIA_THUCHANH', function (Blueprint $table) {
            $table->integer('idTH')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanTH')->unsigned()->nullable()->default(12);
            $table->text('maGV')->nullable()->default('text');
            $table->text('maSSV')->nullable()->default('text');
            $table->integer('lanDG')->unsigned()->nullable()->default(12);
            $table->float('diemDG')->nullable()->default(0.0);
            $table->primary(['idTH','maTieuChuanTH','maGV','maSSV','lanDG']);

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
        Schema::dropIfExists('DANHGIA_THUCHANH');
    }
}
