<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create49ChuongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuong', function (Blueprint $table) {
            $table->increments('id');
            $table->text('tenchuong')->nullable()->default('text');
            $table->text('tenkhongdau')->nullable()->default('text');
            $table->text('mota')->nullable()->default('text');
            $table->boolean('isdelete')->nullable()->default(false);
            $table->integer('soTietLT')->unsigned()->nullable()->default(0);
            $table->integer('soTietTH')->unsigned()->nullable()->default(12);
            $table->string('maHocPhan',255)->nullable();
            $table->timestamps();
            $table->foreign('maHocPhan')->references('maHocPhan')->on('hoc_phan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('49_chuong');
    }
}
