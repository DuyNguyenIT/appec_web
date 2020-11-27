<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create36RaDeTable extends Migration
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
            $table->string('maDe',255)->unique();
            $table->string('maGV',255)->unique();
            $table->string('maHocPhan',255)->unique();
            $table->string('maLop',255)->unique();
            $table->integer('lanThu')->unsigned()->nullable()->default(0);

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
