<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class bai_quy_hoach_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bai_quy_hoach')->insert([
            ['maBaiQH'=>'1','tenBaiQH'=>'text'],
            ['maBaiQH'=>'2','tenBaiQH'=>'text'],
            ['maBaiQH'=>'3','tenBaiQH'=>'text']
        ]);
    }
}
