<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class kqht_hp_cdr3Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kqht_hp_cdrcd3')->insert([
            ['maCDR3'=>'1','maKQHT'=>'1'],
            ['maCDR3'=>'1','maKQHT'=>'2'],
            ['maCDR3'=>'1','maKQHT'=>'3'],
            ['maCDR3'=>'1','maKQHT'=>'4']
         ]);
    }
}
