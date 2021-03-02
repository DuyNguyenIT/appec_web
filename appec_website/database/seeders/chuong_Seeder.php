<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class chuong_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chuong')->insert([
            ['id'=>'1','tenChuong'=>'text','maHocPhan'=>'000000']
         ]);
    }
}
