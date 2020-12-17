<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create33NoiDungQuyHoachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noi_dung_quy_hoach', function (Blueprint $table) {
            
            $table->increments('maNoiDungQH');
            $table->text('tenNoiDungQH')->nullable()->default('text');
            $table->text('noiDungQH')->nullable()->default('text');
            $table->string('maMucDoDG');
            $table->integer('maKQHT')->unsigned()->nullable()->default(12);
            $table->integer('maCTBaiQH')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')->onDelete('cascade');
            $table->foreign('maMucDoDG')->references('maMucDoDG')->on('mucdo_dg')->onDelete('cascade');
            $table->foreign('maCTBaiQH')->references('maCTBaiQH')->on('ct_bai_quy_hoach')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('noi_dung_quy_hoach');
    }
}
