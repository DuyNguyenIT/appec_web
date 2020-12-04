<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create41KhaoSatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KHAO_SAT', function (Blueprint $table) {
            
            $table->string('maPhieuKS',255)->unique();
            $table->integer('maMD')->default(1);
            $table->string('maSSV',255)->unique();
            $table->string('maHocPhan',20)->unique();
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->primary(['maPhieuKS','maMD','maSSV','maHocPhan','maCDR3']);
            
            $table->timestamps();
            $table->foreign('maSSV')->references('maSSV')->on('SINH_VIEN')->onDelete('cascade');
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')->onDelete('cascade');
            $table->foreign('maCDR3')->references('maCDR3')->on('CDR_CD3')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('KHAO_SAT');
    }
}
