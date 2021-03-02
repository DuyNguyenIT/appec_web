<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable60DanhgiaTracnghiemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('danhgia_tracnghiem', function (Blueprint $table) {
           
            $table->increments('id');
            $table->integer('maPhieuCham')->unsigned()->nullable()->default(1);
            $table->integer('maPA')->unsigned()->nullable()->default(1);
            $table->float('diem')->nullable()->default(0.0);
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
        Schema::dropIfExists('table_60_danhgia_tracnghiem');
    }
}
