<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class mucDoDG_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mucdo_dg')->insert([
            ['maMucDoDG'=>'1','tenMucDoDG'=>"Nhớ"],
            ['maMucDoDG'=>'2','tenMucDoDG'=>"Hiểu"],
            ['maMucDoDG'=>'3','tenMucDoDG'=>"Vận dụng"],
            ['maMucDoDG'=>'4','tenMucDoDG'=>"Phân tích"],
            ['maMucDoDG'=>'5','tenMucDoDG'=>"Đánh giá"],
            ['maMucDoDG'=>'6','tenMucDoDG'=>"Sáng tạo"]
         ]);
    }
}
