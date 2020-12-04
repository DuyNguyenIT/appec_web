<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class loai_danh_gia_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loai_danh_ga')->insert([
            ['maLoaiDG'=>'QT','tenLoaiDG'=>'Đánh giá quá trình'],
            ['maLoaiDG'=>'KT','tenLoaiDG'=>'Đánh giá kết thúc môn']
         ]);
    }
}
