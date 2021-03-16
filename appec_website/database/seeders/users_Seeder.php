<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class users_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['username'=>'admin','password'=>'21232f297a57a5a743894a0e4a801fc3','permission'=>1], //admin - quản trị
            ['username'=>'ptpnam','password'=>'202cb962ac59075b964b07152d234b70','permission'=>2],//123 - giảng viên
            ['username'=>'pttmai','password'=>'202cb962ac59075b964b07152d234b70','permission'=>2],//123 - giảng viên
            ['username'=>'giaovu','password'=>'202cb962ac59075b964b07152d234b70','permission'=>3],//123 - giáo vụ khoa
            ['username'=>'bomon','password'=>'202cb962ac59075b964b07152d234b70','permission'=>3],//123 - bộ môn
         ]);
    }
}
