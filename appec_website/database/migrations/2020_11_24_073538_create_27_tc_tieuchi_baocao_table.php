<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create27TcTieuchiBaocaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TC_DANHGIA_BAOCAO', function (Blueprint $table) {
            $table->increments('idTieuChiBC');
            $table->text('tenTieuChiBC')->nullable()->default('tenTieuChiBC');
            $table->float('diemTieuChiBC')->nullable()->default(0.0);
            $table->integer('idBC')->unsigned()->nullable()->default(12);
            $table->integer('maTieuChuanBC')->unsigned()->nullable()->default(12);

            $table->foreign(['idBC','maTieuChuanBC'])->references(['idBC','maTieuChuanBC'])->on('TIEUCHUAN_BAOCAO')->onDelete('cascade');
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
        Schema::dropIfExists('TC_DANHGIA_BAOCAO');
    }
}
