<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class cau_hoi_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cau_hoi')->insert([
            ['maCauHoi'=>'1','noiDungCauHoi'=>'quyển báo cáo','maKQHT'=>'1','maLoaiHTDG'=>'T8','id_muc'=>1]
         ]);
    }
}
