<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class loai_cau_hoi_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loai_cau_hoi')->insert([
            ['id'=>'1','tenLoaiCauHoi'=>'Tự luận'],
            ['id'=>'2','tenLoaiCauHoi'=>'Trắc nghiệm'],
            ['id'=>'3','tenLoaiCauHoi'=>'Thực hành'],
            ['id'=>'4','tenLoaiCauHoi'=>'Đồ án'],
         ]);
    }
}
