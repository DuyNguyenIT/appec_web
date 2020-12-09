<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create43CoNdqhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_ndqh', function (Blueprint $table) {
            $table->string('maHocPhan');
            $table->string('maKQHT');
            $table->integer('maBaiQH')->unsigned()->nullable()->default(12);
            $table->string('maMucDoDG');
            $table->primary(['maHocPhan','maKQHT','maBaiQH','maMucDoDG']);

            
            $table->text('noiDungQH')->nullable()->default('text');
            $table->boolean('isDelete')->nullable()->default(false);
            
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
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
        Schema::dropIfExists('43_co_ndqh');
    }
}
