<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class hocphan_ct_khoi_kien_thuc_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocphan_ctkhoikienthuc')->insert([
            ['maHocPhan'=>'220100','maCTKhoiKT'=>'A1']
         ]);
    }
}
