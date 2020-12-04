<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class mon_tien_quyet_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mon_tien_quyet')->insert([
            ['maHocPhan'=>'220092','maMonTienQuyet'=>'220100']
         ]);
    }
}
