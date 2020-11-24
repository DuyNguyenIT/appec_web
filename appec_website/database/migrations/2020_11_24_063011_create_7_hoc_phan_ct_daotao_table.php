<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create7HocPhanCtDaotaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_CTDAOTAO', function (Blueprint $table) {
            $table->string('maHocPhan',255)->unique()->default('text');
            $table->integer('maCT')->unsigned()->nullable()->default(12);
            $table->text('hocKiTheoCTDT')->nullable()->default('text');
            $table->primary(['maHocPhan', 'maCT']);

            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')
                ->onUpdate('restrict')
                ->onDelete('cascade');
            $table->foreign('maCT')->references('maCT')->on('CT_DAO_TAO')
                ->onUpdate('restrict')
                ->onDelete('cascade');
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
