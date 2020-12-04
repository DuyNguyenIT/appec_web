<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create18GiangDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GIANGDAY', function (Blueprint $table) {
            $table->string('maHocPhan',20)->unique();
            $table->string('maLop',20)->unique();
            $table->string('maGV',20)->unique();
            $table->string('maHK',20)->unique();
            $table->string('namHoc',20)->unique();
            $table->primary(['maHocPhan','maLop','maGV','maHK','namHoc']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maLop')->references('maLop')->on('LOP')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maGV')->references('maGV')->on('GIANG_VIEN')
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
