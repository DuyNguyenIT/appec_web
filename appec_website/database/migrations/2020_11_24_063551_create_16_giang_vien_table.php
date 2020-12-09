<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create16GiangVienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GIANG_VIEN', function (Blueprint $table) {
            $table->string('maGV',255)->unique();
            $table->primary('maGV');
            $table->text('hoGV')->nullable()->default('text');
            $table->text('tenGV')->nullable()->default('text');
            $table->string('username');
            $table->text('email')->nullable()->default('text');
            $table->boolean('isDelete')->nullable()->default(false);
            $table->timestamps();
            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GIANG_VIEN');
    }
}
