<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create23GiangDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GIANGDAY', function (Blueprint $table) {
            $table->string('maHocPhan',20);
            $table->string('maLop',20);
            $table->string('maGV',20);
            $table->string('maHK',20);
            $table->string('namHoc',20);
            $table->integer('maBaiQH')->unsigned()->nullable()->default(12);
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);

            $table->primary(['maHocPhan','maLop','maGV','maHK','namHoc','maBaiQH','maCDR3']);

            $table->boolean('isDelete')->nullable()->default(false);
            $table->foreign('maBaiQH')->references('maBaiQH')->on('BAI_QUY_HOACH')->onDelete('cascade');
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maLop')->references('maLop')->on('LOP')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maGV')->references('maGV')->on('GIANG_VIEN')
                ->onUpdate('restrict')
                ->onDelete('cascade');   
            $table->foreign('maCDR3')->references('maCDR3')->on('CDR_CD3')
                ->onUpdate('restrict')
                ->onDelete('cascade');  
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
        Schema::dropIfExists('GIANGDAY');
    }
}
