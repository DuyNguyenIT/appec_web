<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class cdr1_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cdr_cd1')->insert([
            ['maCDR1'=>'1','maCDR1VB'=>'1','tenCDR1'=>'Kiến thức và lập luận ngành'],
            ['maCDR1'=>'2','maCDR1VB'=>'2','tenCDR1'=>'Kỹ năng phẩm chất cá nhân và nghề nghiệp'],
            ['maCDR1'=>'3','maCDR1VB'=>'3','tenCDR1'=>'Kỹ năng và phẩm chất giữa các cá nhân'],
            ['maCDR1'=>'4','maCDR1VB'=>'4','tenCDR1'=>'Năng lực thực hành nghề nghiệp']
         ]);
    }
}
