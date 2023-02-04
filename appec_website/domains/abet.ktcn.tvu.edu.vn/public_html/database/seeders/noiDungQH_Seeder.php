<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class noiDungQH_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('noi_dung_quy_hoach')->insert([
            ['maNoiDungQH'=>'1','tenNoiDungQH'=>"Chương I hoặc KQHT 1 hoặc Đề mục 1",'maCTBaiQH'=>'3','maKQHT'=>'1','maMucDoDG'=>'1'],
            ['maNoiDungQH'=>'2','tenNoiDungQH'=>"Chương II hoặc KQHT 2 hoặc Đề mục 2",'maCTBaiQH'=>'3','maKQHT'=>'2','maMucDoDG'=>'1'],
            ['maNoiDungQH'=>'3','tenNoiDungQH'=>"Chương III hoặc KQHT 3 hoặc Đề mục 3",'maCTBaiQH'=>'3','maKQHT'=>'2','maMucDoDG'=>'1'],
         ]);
    }
}
