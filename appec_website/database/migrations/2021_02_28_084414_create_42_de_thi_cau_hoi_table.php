<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create42DeThiCauHoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DE_THI_CAU_HOI', function (Blueprint $table) {
            $table->integer('maDe')->unsigned()->nullable()->default(12);
            $table->integer('maCauHoi')->unsigned()->nullable()->default(1);
            $table->primary(['maDe','maCauHoi']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maDe')->references('maDe')->on('DE_THI')->onDelete('cascade');
            $table->foreign('maCauHoi')->references('maCauHoi')->on('CAU_HOI')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DE_THI_CAU_HOI');
    }
}
