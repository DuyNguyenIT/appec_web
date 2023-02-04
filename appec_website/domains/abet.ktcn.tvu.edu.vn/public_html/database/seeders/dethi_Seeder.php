<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class dethi_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('de_thi')->insert([
            ['maDe'=>'1','maDeVB'=>'213','tenDe'=>'Xây dựng cơ sở dữ liệu quản lý thư viện','maCTBaiQH'=>'3'],
            ['maDe'=>'2','maDeVB'=>'124','tenDe'=>'Xây dựng cơ sở dữ liệu cho website tin tức','maCTBaiQH'=>'3'],
            ['maDe'=>'3','maDeVB'=>'234','tenDe'=>'Xây dựng cơ sở dữ liệu cho website bán điên thoại di động','maCTBaiQH'=>'3'],
            ['maDe'=>'4','maDeVB'=>'432','tenDe'=>'Xây dựng cơ sở dữ liệu cho website quản lý kết quả học tập','maCTBaiQH'=>'3'],
            ['maDe'=>'5','maDeVB'=>'435','tenDe'=>'Xây dựng cơ sở dữ liệu cho website hỗ trợ khách hàng doanh nghiệp','maCTBaiQH'=>'3']
        ]);
    }
}
