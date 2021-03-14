<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create31LoaiHtDanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOAI_HT_DANHGIA', function (Blueprint $table) {
            $table->string('maLoaiHTDG',255)->unique();
            $table->primary('maLoaiHTDG');
            $table->text('tenLoaiHTDG')->nullable()->default(null);
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
        Schema::dropIfExists('LOAI_HT_DANHGIA');
    }
}
