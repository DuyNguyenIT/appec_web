<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create53LoaiCauHoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loai_cau_hoi', function (Blueprint $table) {
            $table->increments('id');
            $table->text('tenLoaiCauHoi')->nullable()->default('text');
            $table->boolean('isdelete')->nullable()->default(false);
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
        Schema::dropIfExists('53_loai_cau_hoi');
    }
}
