<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ct_dao_tao_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ct_dao_tao')->insert([
            ['maCT'=>'1','tenCT'=>'Công nghệ thông tin (cử nhân)','maBac'=>'ĐH','maCNganh'=>'1','maHe'=>'CQ'],
            ['maCT'=>'2','tenCT'=>'Công nghệ thông tin (kỹ sư 8 HK cũ)','maBac'=>'ĐH','maCNganh'=>'2','maHe'=>'CQ'],
            ['maCT'=>'3','tenCT'=>'Công nghệ thông tin (kỹ sư 8 HK mới)','maBac'=>'ĐH','maCNganh'=>'2','maHe'=>'CQ'],
            ['maCT'=>'4','tenCT'=>'Quản trị mạng','maBac'=>'ĐH','maCNganh'=>'4','maHe'=>'CQ'],
            ['maCT'=>'5','tenCT'=>'Hệ thống thông tin quản lý','maBac'=>'ĐH','maCNganh'=>'3','maHe'=>'CQ']
         ]);
    }
}
