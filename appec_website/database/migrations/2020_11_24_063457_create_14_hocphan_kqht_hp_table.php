<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create14HocphanKqhtHpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_KQHT_HP', function (Blueprint $table) {
            $table->string('maHocPhan',255);
            $table->integer('maKQHT')->unsigned()->nullable()->default(12);
            $table->primary(['maHocPhan', 'maKQHT']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();

            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
            ->onUpdate('restrict')
            ->onDelete('cascade');
            $table->foreign('maKQHT')->references('maKQHT')->on('KQHT_HP')
            ->onUpdate('restrict')
            ->onDelete('cascade');
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
