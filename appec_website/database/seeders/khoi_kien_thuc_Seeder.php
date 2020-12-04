<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class khoi_kien_thuc_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khoi_kien_thuc')->insert([
            ['maKhoiKT'=>'A','tenKhoiKT'=>'Kiến thức giáo dục đại cương','tongSoTC'=>'60'],
            ['maKhoiKT'=>'B','tenKhoiKT'=>'Kiến thức giáo dục chuyên nghiệp','tongSoTC'=>'90']
         ]);
    }
}
