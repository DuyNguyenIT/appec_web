<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create23HocphanKhoiKienThucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_KHOIKIENTHUC', function (Blueprint $table) {
            $table->string('maHocPhan',20)->unique();
            $table->integer('maKhoiKT')->unsigned()->nullable()->default(12);
            $table->primary(['maHocPhan','maKhoiKT']);
            $table->timestamps();
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')->onDelete('cascade');
            $table->foreign('maKhoiKT')->references('maKhoiKT')->on('KHOI_KIEN_THUC')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HOCPHAN_KHOIKIENTHUC');
    }
}
