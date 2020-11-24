<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create5HocPhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOC_PHAN', function (Blueprint $table) {
            $table->string('maHocPhan',255)->unique();
            $table->primary('maHocPhan');
            $table->text('tenHocPhan')->nullable()->default('text');
            $table->integer('tongSoTinChi')->unsigned()->nullable()->default(12);
            $table->integer('tinChiLyThuyet')->unsigned()->nullable()->default(12);
            $table->integer('tinChiThucHanh')->unsigned()->nullable()->default(12);
            $table->text('moTaHocPhan')->nullable()->default('text');
            $table->integer('maLoaiHocPhan')->unsigned()->nullable()->default(12);
            $table->timestamps();

            $table->foreign('maLoaiHocPhan')->references('maLoaiHocPhan')->on('LOAI_HOC_PHAN')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HOC_PHAN');
    }
}
