<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class bac_dao_tao_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bac_dao_tao')->insert([
           ['maBac'=>'CĐ','tenBac'=>'Cao Đẳng'],
           ['maBac'=>'ĐH','tenBac'=>'Đại học'],
           ['maBac'=>'CH','tenBac'=>'Cao học'],
           ['maBac'=>'NCS','tenBac'=>'Nghiên cứu sinh'],
        ]);
    }
}
