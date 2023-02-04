<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class he_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('he')->insert([
            ['maHe'=>'CQ','tenHe'=>'Chính quy'],
            ['maHe'=>'LT','tenHe'=>'Liên thông'],
            ['maHe'=>'TX','tenHe'=>'Giáo dục từ xa'],
            ['maHe'=>'VLVH','tenHe'=>'Vừa làm vừa học'],
            ['maHe'=>'VB','tenHe'=>'Văn bằng hai']
         ]);
    }
}
