<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class giang_day_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::table('giangday')->insert([
            ['maHocPhan'=>'220228','maLop'=>'DA16TT','maGV'=>'1234','maHK'=>'HK1','namHoc'=>'2020-2021','maBaiQH'=>'1','maCDR3'=>'1'],
            ['maHocPhan'=>'220228','maLop'=>'DA16TT','maGV'=>'1234','maHK'=>'HK1','namHoc'=>'2020-2021','maBaiQH'=>'1','maCDR3'=>'2'],
            ['maHocPhan'=>'220228','maLop'=>'DA16TT','maGV'=>'1234','maHK'=>'HK1','namHoc'=>'2020-2021','maBaiQH'=>'1','maCDR3'=>'3'],
         ]);
    }
}
