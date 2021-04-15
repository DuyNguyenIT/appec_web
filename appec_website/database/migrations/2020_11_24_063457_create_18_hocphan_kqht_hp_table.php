<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create18HocphanKqhtHpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_KQHT_HP', function (Blueprint $table) {
            $table->increments('id');
            $table->string('maHocPhan',191);
            $table->integer('maKQHT')->unsigned()->nullable()->default(12);
            $table->integer('maCDR3')->unsigned()->nullable()->default(12);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
            ->onUpdate('restrict')
            ->onDelete('cascade');
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')
            ->onUpdate('restrict')
            ->onDelete('cascade');
            $table->foreign('maCDR3')->references('maCDR3')->on('CDR_CD3')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('HOCPHAN_KQHT_HP');
    }
}
