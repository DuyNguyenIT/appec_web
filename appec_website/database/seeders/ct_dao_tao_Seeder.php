<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
            ['maCT'=>'1','tenCT'=>'Công nghệ thông tin (cử nhân)'],
            ['maCT'=>'2','tenCT'=>'Liên thông'],
            ['maCT'=>'3','tenCT'=>'Giáo dục từ xa'],
            ['maCT'=>'4','tenCT'=>'Vừa làm vừa học'],
            ['maCT'=>'5','tenCT'=>'Văn bằng hai']
         ]);
    }
}
