<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create41RaDeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RA_DE', function (Blueprint $table) {
            $table->increments('id_RaDe');
            $table->integer('maDe')->unsigned()->nullable()->default(12);
            
            $table->string('maGV',255);
            $table->string('maHocPhan',255);
            $table->string('maLop',255);
            $table->integer('lanThu')->unsigned()->nullable()->default(0);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maDe')->references('maDe')->on('DE_THI')->onDelete('cascade');
            $table->foreign('maGV')->references('maGV')->on('GIANG_VIEN')->onDelete('cascade');
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')->onDelete('cascade');
            $table->foreign('maLop')->references('maLop')->on('LOP')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RA_DE');
    }
}
