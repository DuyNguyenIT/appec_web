<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class tieu_chuan_danh_gia_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tieuchuan_danhgia')->insert([
            ['maTCDG'=>'1','tenTCDG'=>'Hình thức','maNoiDungQH'=>'1','diem'=>'1'],
            // ['tenTCDG'=>'Bố cục','maNoiDungQH'=>'','diem'=>'1'],
            // ['tenTCDG'=>'Nội dung','maNoiDungQH'=>'','diem'=>'5'],
            // ['tenTCDG'=>'Báo cáo','maNoiDungQH'=>'','diem'=>'3']
         ]);
    }
}
