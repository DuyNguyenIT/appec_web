<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create30LoaiDanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOAI_DANH_GIA', function (Blueprint $table) {
            $table->increments('maLoaiDG');
            $table->text('tenLoaiDG')->nullable()->default(null);
            $table->boolean('isDelete')->nullable()->default(false);
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
        Schema::dropIfExists('LOAI_DANH_GIA');
    }
}
