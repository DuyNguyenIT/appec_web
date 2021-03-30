<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable56PhuongAnTuLuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phuong_an_tu_luan', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('noiDungPA')->nullable()->default(null);
            $table->float('diemPA')->nullable()->default(0.0);
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->foreign('maCDR3')->references('maCDR3')->on('cdr_cd3')->onDelete('cascade');
            $table->timestamps();
            $table->integer('maChuanAbet')->unsigned()->nullable()->default(1);
  
            $table->foreign('maChuanAbet')->references('maChuanAbet')->on('chuan_abet')
            ->onUpdate('restrict')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_56_phuong_an_tu_luan');
    }
}
