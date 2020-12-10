<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class lop_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lop')->insert([
            ['maLop'=>'DA16TT','tenLop'=>'ĐH Công nghệ thông tin 2016','namTS'=>'2016']
         ]);
    }
}
