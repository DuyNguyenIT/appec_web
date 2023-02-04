<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class cau_hoi_tieu_chi_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cau_hoi_tcchamdiem')->insert([
            ['maCauHoi'=>'1','maTCCD'=>'1','maTCDG'=>'1'],
            ['maCauHoi'=>'1','maTCCD'=>'2','maTCDG'=>'1'],
            ['maCauHoi'=>'1','maTCCD'=>'3','maTCDG'=>'1'],
            ['maCauHoi'=>'1','maTCCD'=>'4','maTCDG'=>'1']
         ]);
    }
}
