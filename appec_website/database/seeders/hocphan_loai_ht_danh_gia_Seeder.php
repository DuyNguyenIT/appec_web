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
        DB::table('hocphan_loai_hinhthuc_dg')->insert([
            ['maHocPhan'=>'220228','maLoaiDG'=>'1','maLoaiHTDG'=>'1','trongSo'=>'25'],
            ['maHocPhan'=>'220228','maLoaiDG'=>'1','maLoaiHTDG'=>'2','trongSo'=>'25'],
            ['maHocPhan'=>'220228','maLoaiDG'=>'2','maLoaiHTDG'=>'8','trongSo'=>'50']
         ]);
    }
}
