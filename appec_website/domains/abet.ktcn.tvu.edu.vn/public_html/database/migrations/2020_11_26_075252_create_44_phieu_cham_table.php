<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create44PhieuChamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phieu_cham', function (Blueprint $table) {
            $table->increments('maPhieuCham');
            $table->string('maGV',191);
            $table->string('maSSV',191);
            $table->integer('maDe')->unsigned()->nullable()->default(1);

            
            $table->text('diaDiem')->nullable()->default(null);
            $table->text('ghiChu')->nullable()->default(null);
            $table->float('diemSo')->nullable()->default(0.0);
            $table->text('diemChu')->nullable()->default(null);
            $table->text('yKienDongGop')->nullable()->default(null);
            $table->timestamp('ngayCham')->useCurrent = true;
            $table->boolean('isDelete')->nullable()->default(false);
            $table->boolean('trangThai')->nullable()->default(false);
            $table->integer('xepHang')->unsigned()->nullable()->default(1);
            $table->integer('loaiCB')->unsigned()->nullable()->default(1);

            
            $table->foreign('maGV')->references('maGV')->on('GIANG_VIEN')->onDelete('cascade');
            $table->foreign('maSSV')->references('maSSV')->on('SINH_VIEN')->onDelete('cascade');
            $table->foreign('maDe')->references('maDe')->on('DE_THI')->onDelete('cascade');
        
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
        Schema::dropIfExists('phieu_cham');
    }
}
