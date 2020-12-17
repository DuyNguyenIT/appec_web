<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create14CdrCd3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CDR_CD3', function (Blueprint $table) {
            $table->increments('maCDR3');
            $table->text('maCDR3VB')->nullable()->default('text');
            $table->text('tenCDR3')->nullable()->default('text');
            $table->integer('maCDR2')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('maCDR2')->references('maCDR2')->on('CDR_CD2')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CDR_CD3');
    }
}
