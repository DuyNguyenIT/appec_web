<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Create35HocphanLoaidanhgiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('HOCPHAN_LOAIDANHGIA', function (Blueprint $table) {
            $table->text('maHocPhan')->nullable()->default('text');
            $table->integer('maLoaiDG')->unsigned()->nullable()->default(12);
            $table->text('maGV')->nullable()->default('text');
 
            $table->primary(['maHocPhan','maLoaiDG','maGV']);
            $table->integer('trongSo')->unsigned()->nullable()->default(12);
            
            $table->primary(['maHocPhan','maLoaiDG','maGV']);
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
        Schema::dropIfExists('HOCPHAN_LOAIDANHGIA');
    }
}
