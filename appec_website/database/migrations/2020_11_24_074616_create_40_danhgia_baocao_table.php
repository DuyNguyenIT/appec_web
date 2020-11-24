<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create40DanhgiaBaocaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DANHGIA_BAOCAO', function (Blueprint $table) {
            $table->integer('idBC')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanBC')->unsigned()->nullable()->default(12);
            $table->text('maGV')->nullable()->default('text');
            $table->text('maSSV')->nullable()->default('text');
            $table->integer('lanDG')->unsigned()->nullable()->default(12);
            $table->float('diemDG')->nullable()->default(0.0);
            $table->primary(['idBC','maTieuChuanBC','maGV','maSSV','lanDG']);
            
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
        Schema::dropIfExists('DANHGIA_BAOCAO');
    }
}
