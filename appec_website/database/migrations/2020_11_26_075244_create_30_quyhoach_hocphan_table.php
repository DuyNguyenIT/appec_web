<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create30QuyhoachHocphanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('QUYHOACH_HOCPHAN', function (Blueprint $table) {
            $table->increments('id_QH_HP');
            $table->string('maHocPhan',10)->unique();
            $table->integer('maLoaiDG')->length(5)->default(12);
            $table->integer('maLoaiHTDG')->length(5)->default(12);
            $table->integer('maBaiQH')->length(5)->default(12);
            $table->string('maGV',10)->unique();


            $table->timestamps();
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
            ->onUpdate('restrict')
            ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('QUYHOACH_HOCPHAN');
    }
}
