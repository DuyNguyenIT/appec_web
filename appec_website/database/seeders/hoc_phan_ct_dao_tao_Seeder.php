<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class hoc_phan_ct_dao_tao_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocphan_ctdaotao')->insert([
            ['maHocPhan'=>'220100','maCT'=>'1','phanPhoiHocKy'=>'4'],
            ['maHocPhan'=>'220100','maCT'=>'2','phanPhoiHocKy'=>'4'],
            ['maHocPhan'=>'220100','maCT'=>'3','phanPhoiHocKy'=>'4'],
            ['maHocPhan'=>'220100','maCT'=>'4','phanPhoiHocKy'=>'4'],
            ['maHocPhan'=>'220100','maCT'=>'5','phanPhoiHocKy'=>'4'],
            ['maHocPhan'=>'220092','maCT'=>'1','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'220092','maCT'=>'2','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'220092','maCT'=>'3','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'220092','maCT'=>'5','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'220228','maCT'=>'1','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'220228','maCT'=>'2','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'220228','maCT'=>'3','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'220228','maCT'=>'5','phanPhoiHocKy'=>'1'],
            ['maHocPhan'=>'180001','maCT'=>'1','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'180001','maCT'=>'2','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'180001','maCT'=>'3','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'180001','maCT'=>'4','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'180001','maCT'=>'5','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'190001','maCT'=>'1','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'190001','maCT'=>'2','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'190001','maCT'=>'3','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'190001','maCT'=>'4','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'190001','maCT'=>'5','phanPhoiHocKy'=>'2'],
            ['maHocPhan'=>'220094','maCT'=>'1','phanPhoiHocKy'=>'6'],
            ['maHocPhan'=>'220094','maCT'=>'3','phanPhoiHocKy'=>'6'],
            ['maHocPhan'=>'220055','maCT'=>'1','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'220055','maCT'=>'2','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'220055','maCT'=>'3','phanPhoiHocKy'=>'6'],
            ['maHocPhan'=>'220055','maCT'=>'5','phanPhoiHocKy'=>'6'],
            ['maHocPhan'=>'220103','maCT'=>'2','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'220103','maCT'=>'3','phanPhoiHocKy'=>'5'],
            ['maHocPhan'=>'220103','maCT'=>'4','phanPhoiHocKy'=>'7'],
            ['maHocPhan'=>'220103','maCT'=>'5','phanPhoiHocKy'=>'4'],
         ]);
    }
}
