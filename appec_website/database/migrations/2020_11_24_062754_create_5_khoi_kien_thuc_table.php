<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create5KhoiKienThucTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('KHOI_KIEN_THUC', function (Blueprint $table) {
            $table->string('maKhoiKT',255)->unique();
            $table->primary('maKhoiKT');
            $table->text('tenKhoiKT')->nullable()->default('text'); //tên khối kiến thức
            $table->integer('tongSoTC')->unsigned()->nullable()->default(12); //tống số tín chỉ
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
        Schema::dropIfExists('KHOI_KIEN_THUC');
    }
}
