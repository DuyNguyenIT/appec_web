<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create17LopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LOP', function (Blueprint $table) {
            $table->string('maLop',255)->unique();
            $table->primary('maLop');
            $table->text('tenLop')->nullable()->default('text');
            $table->text('namTS')->nullable()->default('text');
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
        Schema::dropIfExists('LOP');
    }
}
