<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create16KqhtHpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KQHT_HP', function (Blueprint $table) {
            $table->increments('maKQHT');
            $table->text('tenKQHT')->nullable()->default('text');
            $table->timestamps();
            $table->boolean('isDelete')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('KQHT_HP');
    }
}
