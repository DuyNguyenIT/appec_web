<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create9CtDaotaoCdrCd1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CTDT_CDRCD1', function (Blueprint $table) {
            $table->integer('maCT')->unsigned()->nullable()->default(12);
            $table->integer('maCDR1')->unsigned()->nullable()->default(12);
            $table->primary(['maCT', 'maCDR1']);
            $table->boolean('isDelete')->nullable()->default(false);
            
            $table->foreign('maCDR1')->references('maCDR1')->on('CDR_CD1')
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
        Schema::dropIfExists('CTDT_CDRCD1');
    }
}
