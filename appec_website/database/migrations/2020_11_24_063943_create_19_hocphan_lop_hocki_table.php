<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create19HocphanLopHockiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_HOCKY_LOP', function (Blueprint $table) {
            $table->string('maHocPhan',20)->unique();
            $table->string('maLop',20)->unique();
            $table->string('maHK',20)->unique();
            $table->primary(['maHocPhan','maLop','maHK']);

            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('maLop')->references('maLop')->on('LOP')->onUpdate('restrict')->onDelete('cascade');
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
        Schema::dropIfExists('HOCPHAN_HOCKY_LOP');
    }
}
