<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create29BaiQuyHoachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('BAI_QUY_HOACH', function (Blueprint $table) {
            $table->increments('maBaiQH');
            $table->text('tenBaiQH')->nullable()->default('text');
            $table->text('noiDungBaiQH')->nullable()->default('text');
            
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
        Schema::dropIfExists('BAI_QUY_HOACH');
    }
}
