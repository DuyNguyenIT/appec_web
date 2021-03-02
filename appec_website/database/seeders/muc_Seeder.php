<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class muc_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('muc')->insert([
            ['id'=>'1','tenMuc'=>'text','id_chuong'=>1]
         ]);
    }
}
