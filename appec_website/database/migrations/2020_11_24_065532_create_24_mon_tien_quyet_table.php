<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create24MonTienQuyetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MON_TIEN_QUYET', function (Blueprint $table) {
            $table->string('maHocPhan',20)->unique();
            $table->string('maMonTienQuyet',20)->unique();
            $table->primary(['maHocPhan','maMonTienQuyet']);
            $table->boolean('isDelete')->nullable()->default(false);
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
        Schema::dropIfExists('MON_TIEN_QUYET');
    }
}
