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
            $table->text('password')->nullable()->default('text');
            $table->text('email')->nullable()->default('text');
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
        Schema::dropIfExists('GIANG_VIEN');
    }
}
