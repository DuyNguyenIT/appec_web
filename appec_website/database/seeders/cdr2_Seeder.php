<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class cdr2_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cdr_cd2')->insert([
            ['maCDR2'=>'1','maCDR2VB'=>'1.1','tenCDR2'=>'Kiến thức đại cương','maCDR1'=>'1'],
            ['maCDR2'=>'2','maCDR2VB'=>'1.2','tenCDR2'=>'Kiến thức cơ sở ngành','maCDR1'=>'1'],
            ['maCDR2'=>'3','maCDR2VB'=>'1.3','tenCDR2'=>'Kiến thức chuyên ngành','maCDR1'=>'1'],
            ['maCDR2'=>'4','maCDR2VB'=>'1.4','tenCDR2'=>'Kiến thức thực tập và tốt nghiệp','maCDR1'=>'1'],

            ['maCDR2'=>'5','maCDR2VB'=>'2.1','tenCDR2'=>'Khả năng lập luận và tư duy giải quyết vấn đề','maCDR1'=>'1'],
            ['maCDR2'=>'6','maCDR2VB'=>'2.2','tenCDR2'=>'Khả năng nghiên cứu và khám phá kiến thức','maCDR1'=>'1'],
            ['maCDR2'=>'7','maCDR2VB'=>'2.3','tenCDR2'=>'Khả năng tư duy hệ thống','maCDR1'=>'1'],
            ['maCDR2'=>'8','maCDR2VB'=>'2.4','tenCDR2'=>'Kỹ năng và phẩm chất cá nhân','maCDR1'=>'1'],
            ['maCDR2'=>'9','maCDR2VB'=>'2.5','tenCDR2'=>'Kỹ năng và phẩm chất đạo đức cá nhân','maCDR1'=>'1']
         ]);
    }
}
