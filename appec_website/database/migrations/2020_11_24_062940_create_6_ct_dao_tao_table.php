<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create6CtDaoTaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CT_DAO_TAO', function (Blueprint $table) {
            $table->increments('maCT');
            $table->text('tenCT')->nullable()->default('text');
            $table->integer('maBac')->unsigned()->nullable()->default(12);
            $table->integer('maNganh')->unsigned()->nullable()->default(12);
            $table->integer('maHe')->unsigned()->nullable()->default(12);


            $table->timestamps();
            $table->foreign('maBac')->references('maBac')->on('BAC_DAO_TAO')->onDelete('cascade');
            $table->foreign('maNganh')->references('maNganh')->on('NGANH')->onDelete('cascade');
            $table->foreign('maHe')->references('maHe')->on('HE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CT_DAO_TAO');
    }
}
