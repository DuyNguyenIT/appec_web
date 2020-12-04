<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class loai_hoc_phan_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loai_hoc_phan')->insert([
            ['maLoaiHocPhan'=>'TC','tenLoaiHocPhan'=>'Tự chọn'],
            ['maLoaiHocPhan'=>'BB','tenLoaiHocPhan'=>'Bắc buộc']
           
         ]);
    }
}
