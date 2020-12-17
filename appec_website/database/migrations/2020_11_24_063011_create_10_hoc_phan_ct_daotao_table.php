<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create10HocPhanCtDaotaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_CTDAOTAO', function (Blueprint $table) {
            $table->string('maHocPhan',255)->default('text');
            $table->integer('maCT')->unsigned()->nullable()->default(12);
            $table->text('phanPhoiHocKy')->nullable()->default('text');
            $table->primary(['maHocPhan', 'maCT']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->string('maLoaiHocPhan',255);
            
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maCT')->references('maCT')->on('CT_DAO_TAO')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maLoaiHocPhan')->references('maLoaiHocPhan')->on('LOAI_HOC_PHAN')->onDelete('cascade');

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
        Schema::dropIfExists('HOCPHAN_CTDAOTAO');
    }
}
