<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create35DeThiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DE_THI', function (Blueprint $table) {
            $table->string('maDe',255)->unique();
            $table->integer('soCauHoi')->unsigned()->nullable()->default(12);
            $table->integer('maBaiQH')->unsigned()->nullable()->default(12);
            $table->primary(['maDe','soCauHoi','maBaiQH']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('maBaiQH')->references('maBaiQH')->on('BAI_QUY_HOACH')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DE_THI');
    }
}
