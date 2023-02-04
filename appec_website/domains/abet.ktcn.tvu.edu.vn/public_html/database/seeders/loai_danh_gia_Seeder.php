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
        DB::table('loai_danh_gia')->insert([
            ['maLoaiDG'=>'1','tenLoaiDG'=>'Đánh giá quá trình lần 1'],
            ['maLoaiDG'=>'2','tenLoaiDG'=>'Đánh giá quá trình lần 2'],
            ['maLoaiDG'=>'3','tenLoaiDG'=>'Đánh giá kết thúc môn']
         ]);
    }
}
