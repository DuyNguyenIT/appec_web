<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create12HocphanCdrCd3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_CDRCD3', function (Blueprint $table) {
            $table->integer('maCDR3')->unsigned();
            $table->string('maHocPhan')->default(null);
            $table->primary(['maCDR3','maHocPhan']);
            $table->boolean('isDelete')->nullable()->default(false);

            $table->foreign('maCDR3')->references('maCDR3')->on('CDR_CD3')->onDelete('cascade');
            $table->foreign('maHocPhan')->references('maHocPhan')->on('HOC_PHAN')->onDelete('cascade');

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
        Schema::dropIfExists('HOCPHAN_CDRCD3');
    }
}
