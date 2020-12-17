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
            ['maCDR3'=>'1','maCDR3VB'=>'1.1.1','tenCDR3'=>'KN Trình bày văn bảng','maCDR2'=>'1'],
            ['maCDR3'=>'2','maCDR3VB'=>'1.1.2','tenCDR3'=>'Kiến thức khoa học xã hội','maCDR2'=>'1'],
            ['maCDR3'=>'3','maCDR3VB'=>'1.1.3','tenCDR3'=>'Kiến thức khoa học tự nhiên','maCDR2'=>'1'],
            ['maCDR3'=>'4','maCDR3VB'=>'1.1.4','tenCDR3'=>'Kiến thức ngoại ngữ','maCDR2'=>'1'],
            ['maCDR3'=>'5','maCDR3VB'=>'1.1.5','tenCDR3'=>'Kiến thức giáo dục thể chất','maCDR2'=>'1'],
            ['maCDR3'=>'6','maCDR3VB'=>'1.1.6','tenCDR3'=>'Kiến thức giáo dục quốc phòng','maCDR2'=>'1'],
            
         ]);
    }
}
