<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create2NganhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NGANH', function (Blueprint $table) {
            $table->string('maNganh',255)->unique();
            $table->primary('maNganh');
            $table->text('tenNganh')->nullable()->default(null);
            $table->boolean('isDelete')->nullable()->default(false);
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
        Schema::dropIfExists('NGANH');
    }
}
