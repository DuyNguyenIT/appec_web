<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create6CtKhoiKienThucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ct_khoi_kien_thuc', function (Blueprint $table) {
            $table->string('maCTKhoiKT',255)->unique();
            $table->primary('maCTKhoiKT');
            $table->text('tenCTKhoiKT')->nullable()->default('text');
            $table->integer('tongTinChiLTCTKhoiKT')->unsigned()->nullable()->default(12);
            $table->integer('tongTinChiTHCTKhoiKT')->unsigned()->nullable()->default(12);
           
            $table->boolean('isDelete')->nullable()->default(false);
            $table->string('maKhoiKT',255);
            $table->foreign('maKhoiKT')->references('maKhoiKT')->on('khoi_kien_thuc')->onDelete('cascade');
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
        Schema::dropIfExists('ct_khoi_kien_thuc');
    }
}
