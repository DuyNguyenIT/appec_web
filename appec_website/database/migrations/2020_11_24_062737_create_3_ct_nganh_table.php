<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create3CtNganhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_nganh', function (Blueprint $table) {
            $table->increments('maCNganh');
            $table->text('tenCNganh')->nullable()->default(null);
            $table->string('maNganh',191);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->foreign('maNganh')->references('maNganh')->on('NGANH')->onDelete('cascade');
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
        Schema::dropIfExists('ct_nganh');
    }
}
