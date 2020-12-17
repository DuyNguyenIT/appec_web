<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class loai_ht_danh_gia_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loai_ht_danhgia')->insert([
            ['maLoaiHTDG'=>'T1','tenLoaiHTDG'=>'Tự luận'],
            ['maLoaiHTDG'=>'T2','tenLoaiHTDG'=>'Trắc nghiệm'],
            ['maLoaiHTDG'=>'T3','tenLoaiHTDG'=>'Thực hành'],
            ['maLoaiHTDG'=>'T4','tenLoaiHTDG'=>'Bài tập trên lớp'],
            ['maLoaiHTDG'=>'T5','tenLoaiHTDG'=>'Bài tập về nhà'],
            ['maLoaiHTDG'=>'T6','tenLoaiHTDG'=>'Seminar'],
            ['maLoaiHTDG'=>'T7','tenLoaiHTDG'=>'Vấn đáp'],
            ['maLoaiHTDG'=>'T8','tenLoaiHTDG'=>'Đồ án'],
        ]);
    }
}
