<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create40DeThiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DE_THI', function (Blueprint $table) {
            $table->increments('maDe');
            $table->string('maDeVB',255);
            $table->integer('soCauHoi')->unsigned()->nullable()->default(12);
            $table->text('tenDe')->nullable()->default('text');
            $table->integer('thoiGian')->unsigned()->nullable()->default(30);
            $table->integer('maCTBaiQH')->unsigned()->nullable()->default(12);
            $table->text('ghiChu')->nullable()->default('text');
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('DE_THI');
    }
}
