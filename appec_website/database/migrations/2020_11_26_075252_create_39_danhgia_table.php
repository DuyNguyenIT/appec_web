<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create39DanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DANH_GIA', function (Blueprint $table) {
            $table->string('maGV',255)->unique();
            $table->string('maSSV',255)->unique();
            $table->string('maDe',255)->unique();
            $table->integer('maCauHoi')->unsigned()->nullable()->default(12);
            $table->integer('maTCCD')->unsigned()->nullable()->default(12);
            $table->float('diemDG')->nullable()->default(123.45);
            $table->integer('lanDG')->unsigned()->nullable()->default(12);
            $table->primary(['maGV','maSSV','maDe','maCauHoi','maTCCD']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maGV')->references('maGV')->on('GIANG_VIEN')->onDelete('cascade');
            $table->foreign('maSSV')->references('maSSV')->on('SINH_VIEN')->onDelete('cascade');
            $table->foreign('maDe')->references('maDe')->on('DE_THI')->onDelete('cascade');
            $table->foreign('maCauHoi')->references('maCauHoi')->on('CAU_HOI')->onDelete('cascade');
            $table->foreign('maTCCD')->references('maTCCD')->on('TIEU_CHI_CHAM_DIEM')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DANH_GIA');
    }
}
