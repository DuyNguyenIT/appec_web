<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create36QuyhoachBaocaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QUYHOACH_BAOCAO', function (Blueprint $table) {
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->integer('maHocPhan')->unsigned()->nullable()->default(12);
            $table->integer('maLoaiDG')->unsigned()->nullable()->default(12);
            $table->text('maGV')->nullable()->default('text');
            $table->text('maLop')->nullable()->default('text');
            $table->integer('idBC')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanBC')->unsigned()->nullable()->default(12);

            $table->foreign(['maHocPhan','maLoaiDG','maGV'])->references(['maHocPhan','maLoaiDG','maGV'])->on('HOCPHAN_LOAIDANHGIA')->onDelete('cascade');
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
        Schema::dropIfExists('QUYHOACH_BAOCAO');
    }
}
