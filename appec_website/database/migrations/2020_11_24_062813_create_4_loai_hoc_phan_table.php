<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create4LoaiHocPhanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOAI_HOC_PHAN', function (Blueprint $table) {
            $table->string('maLoaiHocPhan',255)->unique();
           $table->primary('maLoaiHocPhan');
            $table->text('tenLoaiHocPhan')->nullable()->default('text');
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
        Schema::dropIfExists('LOAI_HOC_PHAN');
    }
}
