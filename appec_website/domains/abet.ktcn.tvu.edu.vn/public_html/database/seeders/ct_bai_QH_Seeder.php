<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ct_bai_QH_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ct_bai_quy_hoach')->insert([
            ['maCTBaiQH'=>'1','maBaiQH'=>'1','maLoaiDG'=>'1','maLoaiHTDG'=>'T1'],
            ['maCTBaiQH'=>'2','maBaiQH'=>'1','maLoaiDG'=>'2','maLoaiHTDG'=>'T2'],
            ['maCTBaiQH'=>'3','maBaiQH'=>'1','maLoaiDG'=>'3','maLoaiHTDG'=>'T8']
        ]);
    }
}
