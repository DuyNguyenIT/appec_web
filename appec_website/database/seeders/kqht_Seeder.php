<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class kqht_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kqht_hp')->insert([
            ['maKQHT'=>'1','maKQHTVB'=>'L1','tenKQHT'=>'Kiến thức và lập luận ngành'],
            ['maKQHT'=>'2','maKQHTVB'=>'L2','tenKQHT'=>'Kỹ năng cá nhân và nghề nghiệp'],
            ['maKQHT'=>'3','maKQHTVB'=>'L3','tenKQHT'=>'Về kỹ năng giao tiếp: làm việc nhóm và giao tiếp'],
            ['maKQHT'=>'4','maKQHTVB'=>'L4','tenKQHT'=>'Về hình thành ý tưởng, thiết kế, triển khai, vận hành hệ thống trong bối cảnh doang nghiệp xã hội và môi trường']
         ]);
    }
}
