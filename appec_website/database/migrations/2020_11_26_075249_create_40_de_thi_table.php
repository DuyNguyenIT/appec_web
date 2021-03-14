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
            $table->string('maDeVB',191);
            $table->integer('soCauHoi')->unsigned()->nullable()->default(1);
            $table->text('tenDe')->nullable()->default(null);
            $table->integer('thoiGian')->unsigned()->nullable()->default(30);
            $table->integer('maCTBaiQH')->unsigned()->nullable()->default(1);
            $table->text('ghiChu')->nullable()->default(null);
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
