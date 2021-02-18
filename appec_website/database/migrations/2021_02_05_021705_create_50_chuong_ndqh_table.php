<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create50ChuongNdqhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuong_ndqh', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_chuong')->unsigned()->nullable()->default(1);
            $table->integer('maNoiDungQH')->unsigned()->nullable()->default(1);
            $table->foreign('id_chuong')->references('id')->on('chuong')->onDelete('cascade');
            $table->boolean('isDelete')->nullable()->default(false);
            $table->foreign('maNoiDungQH')->references('maNoiDungQH')->on('noi_dung_quy_hoach')->onDelete('cascade');
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
        Schema::dropIfExists('50_chuong_ndqh');
    }
}
