<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create13CdrCd2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CDR_CD2', function (Blueprint $table) {
            $table->increments('maCDR2');
            $table->text('maCDR2VB')->nullable()->default(null);
            $table->text('tenCDR2')->nullable()->default(null);
            $table->integer('maCDR1')->unsigned()->nullable()->default(1);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('maCDR1')->references('maCDR1')->on('CDR_CD1')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CDR_CD2');
    }
}
