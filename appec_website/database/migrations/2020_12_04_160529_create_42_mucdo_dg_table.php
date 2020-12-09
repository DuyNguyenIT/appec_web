<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create42MucdoDgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mucdo_dg', function (Blueprint $table) {
            $table->string('maMucDoDG',255)->unique();
            $table->primary('maMucDoDG');
            $table->text('tenMucDoDG')->nullable()->default('text');
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
        Schema::dropIfExists('42_mucdo_dg');
    }
}
