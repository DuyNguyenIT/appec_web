<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class kqht_hp_cdrcd3_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kqht_hp_cdrcd3')->insert([
            ['maCDR3'=>'3','maKQHT'=>'1'],
            ['maCDR3'=>'4','maKQHT'=>'2'],
            ['maCDR3'=>'5','maKQHT'=>'3'],
            ['maCDR3'=>'6','maKQHT'=>'4']
         ]);
    }
}
