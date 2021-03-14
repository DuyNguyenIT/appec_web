<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable57PhuongAnTracNghiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phuong_an_trac_nghiem', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('noiDungPA')->nullable()->default('text');
            $table->float('diemPA')->nullable()->default(0.0);
            $table->integer('maCauHoi')->unsigned()->nullable()->default(1);
            $table->boolean('isCorrect')->nullable()->default(false);
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->timestamps();
            $table->foreign('maCauHoi')->references('maCauHoi')->on('CAU_HOI')->onDelete('cascade');
            $table->foreign('maCDR3')->references('maCDR3')->on('cdr_cd3')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_57_phuong_an_trac_nghiem');
    }
}
