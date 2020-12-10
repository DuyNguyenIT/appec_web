<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class hoc_phan_kqht_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hocphan_kqht_hp')->insert([
            ['maHocPhan'=>'220228','maKQHT'=>'1'],
            ['maHocPhan'=>'220228','maKQHT'=>'2'],
            ['maHocPhan'=>'220228','maKQHT'=>'3'],
            ['maHocPhan'=>'220228','maKQHT'=>'4']
         ]);
    }
}
