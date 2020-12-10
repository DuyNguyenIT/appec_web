<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class cdr3_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cdr_cd3')->insert([
            ['maCDR3'=>'1','tenCDR3'=>'Kiến thức lý luận chính trị','maCDR2'=>'1'],
            ['maCDR3'=>'2','tenCDR3'=>'Kiến thức khoa học xã hội','maCDR2'=>'1'],
            ['maCDR3'=>'3','tenCDR3'=>'Kiến thức khoa học tự nhiên','maCDR2'=>'1'],
            ['maCDR3'=>'4','tenCDR3'=>'Kiến thức ngoại ngữ','maCDR2'=>'1'],
            ['maCDR3'=>'5','tenCDR3'=>'Kiến thức giáo dục thể chất','maCDR2'=>'1'],
            ['maCDR3'=>'6','tenCDR3'=>'Kiến thức giáo dục quốc phòng','maCDR2'=>'1'],
            
         ]);
    }
}
