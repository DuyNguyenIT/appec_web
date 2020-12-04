<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create19LopHocCtdaotaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOP_HOC_CTDAOTAO', function (Blueprint $table) {
           
            $table->string('maLop',20)->unique();
            $table->integer('maCT')->unsigned()->nullable()->default(12);
            
            $table->primary(['maLop','maCT']);
            $table->boolean('isDelete')->nullable()->default(false);
            $table->foreign('maCT')->references('maCT')->on('CT_DAO_TAO')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign('maLop')->references('maLop')->on('LOP')->onUpdate('restrict')->onDelete('cascade');
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
        Schema::dropIfExists('LOP_HOC_CTDAOTAO');
    }
}
