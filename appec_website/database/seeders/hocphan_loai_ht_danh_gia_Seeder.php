<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class hocphan_loai_ht_danh_gia_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('he')->insert([
            ['maHocPhan'=>'CQ','maLoaiDG'=>'Chính quy'],
            ['maHocPhan'=>'LT','maLoaiDG'=>'Liên thông'],
            ['maHocPhan'=>'TX','maLoaiDG'=>'Giáo dục từ xa'],
            ['maHocPhan'=>'VLVH','maLoaiDG'=>'Vừa làm vừa học'],
            ['maHocPhan'=>'VB','maLoaiDG'=>'Văn bằng hai']
         ]);
    }
}
