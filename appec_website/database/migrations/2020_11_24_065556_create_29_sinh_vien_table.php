<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create29SinhVienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SINH_VIEN', function (Blueprint $table) {
            $table->string('maSSV',20)->unique();
            $table->primary('maSSV');
            $table->text('HoSV')->nullable()->default('text');
            $table->text('TenSV')->nullable()->default('text');
            $table->text('Phai')->nullable()->default('text');
            $table->text('NgaySinh')->nullable()->default('text');
            $table->string('maLop',255);
            $table->foreign('maLop')->references('maLop')->on('LOP')->onDelete('cascade');
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
        Schema::dropIfExists('SINH_VIEN');
    }
}
