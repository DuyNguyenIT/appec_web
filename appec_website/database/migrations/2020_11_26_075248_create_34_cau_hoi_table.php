<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create34CauHoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CAU_HOI', function (Blueprint $table) {
            $table->increments('maCauHoi');
            $table->text('noiDungCauHoi')->nullable()->default('text');
            $table->float('diemCauHoi')->nullable()->default(123.45);

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
        Schema::dropIfExists('CAU_HOI');
    }
}
