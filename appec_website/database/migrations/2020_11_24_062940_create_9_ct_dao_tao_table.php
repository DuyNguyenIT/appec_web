<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create9CtDaoTaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CT_DAO_TAO', function (Blueprint $table) {
            $table->increments('maCT');
            $table->text('tenCT')->nullable()->default('text');
          
            $table->string('maBac',255);
            $table->integer('maCNganh')->unsigned()->nullable()->default(12);
            $table->string('maHe',255);
            $table->boolean('isDelete')->nullable()->default(false);

            $table->timestamps();
            $table->foreign('maBac')->references('maBac')->on('BAC_DAO_TAO')->onDelete('cascade');
            $table->foreign('maCNganh')->references('maCNganh')->on('C_NGANH')->onDelete('cascade');
            $table->foreign('maHe')->references('maHe')->on('HE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CT_DAO_TAO');
    }
}
