<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ct_khoi_kien_thuc_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ct_khoi_kien_thuc')->insert([
            ['maCTKhoiKT'=>'A1','tenCTKhoiKT'=>'Lý luận chính trị','tongTinChiLT'=>'11','tongTinChiTH'=>'0','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A2','tenCTKhoiKT'=>'Khoa học xã hội - Nhân văn nghệ thuật','tongTinChiLT'=>'5','tongTinChiTH'=>'3','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A3','tenCTKhoiKT'=>'Ngoại ngữ','tongTinChiLT'=>'10','tongTinChiTH'=>'6','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A4','tenCTKhoiKT'=>'Toán, Tin học, Khoa học tự nhiên','tongTinChiLT'=>'14','tongTinChiTH'=>'11','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A5','tenCTKhoiKT'=>'Giáo dục thể chất, Giáo dục Quốc phòng - An ninh','tongTinChiLT'=>'0','tongTinChiTH'=>'3','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'B1','tenCTKhoiKT'=>'Kiến thức cơ sở ngành','tongTinChiLT'=>'24','tongTinChiTH'=>'17','maKhoiKT'=>'B'],
            ['maCTKhoiKT'=>'B2','tenCTKhoiKT'=>'Kiến thức chuyên ngành','tongTinChiLT'=>'24','tongTinChiTH'=>'15','maKhoiKT'=>'B'],
            ['maCTKhoiKT'=>'B3','tenCTKhoiKT'=>'Tốt nghiệp','tongTinChiLT'=>'10 ','tongTinChiTH'=>'0','maKhoiKT'=>'B']
         ]);
    }
}
