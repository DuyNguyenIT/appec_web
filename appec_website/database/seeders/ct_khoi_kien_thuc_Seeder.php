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
            ['maCTKhoiKT'=>'A1','tenCTKhoiKT'=>'Lý luận chính trị','tongTinChiLTCTKhoiKT'=>'11','tongTinChiTHCTKhoiKT'=>'0','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A2','tenCTKhoiKT'=>'Khoa học xã hội - Nhân văn nghệ thuật','tongTinChiLTCTKhoiKT'=>'5','tongTinChiTHCTKhoiKT'=>'3','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A3','tenCTKhoiKT'=>'Ngoại ngữ','tongTinChiLTCTKhoiKT'=>'10','tongTinChiTHCTKhoiKT'=>'6','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A4','tenCTKhoiKT'=>'Toán, Tin học, Khoa học tự nhiên','tongTinChiLTCTKhoiKT'=>'14','tongTinChiTHCTKhoiKT'=>'11','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'A5','tenCTKhoiKT'=>'Giáo dục thể chất, Giáo dục Quốc phòng - An ninh','tongTinChiLTCTKhoiKT'=>'0','tongTinChiTHCTKhoiKT'=>'3','maKhoiKT'=>'A'],
            ['maCTKhoiKT'=>'B1','tenCTKhoiKT'=>'Kiến thức cơ sở ngành','tongTinChiLTCTKhoiKT'=>'24','tongTinChiTHCTKhoiKT'=>'17','maKhoiKT'=>'B'],
            ['maCTKhoiKT'=>'B2','tenCTKhoiKT'=>'Kiến thức chuyên ngành','tongTinChiLTCTKhoiKT'=>'24','tongTinChiTHCTKhoiKT'=>'15','maKhoiKT'=>'B'],
            ['maCTKhoiKT'=>'B3','tenCTKhoiKT'=>'Tốt nghiệp','tongTinChiLTCTKhoiKT'=>'10 ','tongTinChiTHCTKhoiKT'=>'0','maKhoiKT'=>'B']
         ]);
    }
}
