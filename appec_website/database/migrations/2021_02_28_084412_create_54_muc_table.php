<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create54MucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('muc', function (Blueprint $table) {
            $table->increments('id');
            $table->text('maMucVB')->nullable()->default(null);
            $table->text('tenMuc')->nullable()->default(null);
            $table->integer('id_chuong')->unsigned()->nullable()->default(1);
            $table->timestamps();
            $table->foreign('id_chuong')->references('id')->on('chuong')->onDelete('cascade');
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('muc');
    }
}
